<?php

namespace Tests\Feature\Admin;

use App\Enums\Menu;
use App\Models\Admin\Role;
use App\Models\Admin\Team;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class ManageUserRoleTest extends TestCase
{
    public function testCanBeAccessedOnlyByAdmin(): void
    {
        $user = factory(User::class)->make(['is_admin' => true]);

        $response = $this->actingAs($user)->get('/admin/manage-user-roles');
        $response->assertViewIs('auth.admin.manage_user_role')->assertStatus(ResponseAlias::HTTP_OK);
        $this->view('auth.admin.manage_user_role', ['setActiveMenu' => Menu::ADMIN->value, 'roles' => Role::get()]);
    }

    public function testCannotBeAccessedByNoAdmin(): void
    {
        $user = factory(User::class)->make(['is_admin' => false]);

        $this->actingAs($user)->get('/admin/manage-user-roles')->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function testAdminCanSearchForUsers(): void
    {
        $admin        = factory(User::class)->make(['is_admin' => 1]);
        $searchedUser = factory(User::class)->create(['first_name' => 'SomeUser', 'team_id' => null]);
        $term         = $searchedUser->first_name;

        $response = $this->actingAs($admin)->getJson("admin/find-user?term=$term");
        $response->assertSessionDoesntHaveErrors(['term' => 'The term field is required.']);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(
            [
                [
                    'id'        => $searchedUser->id,
                    'full_name' => "$term $searchedUser->last_name",
                    'role_id'   => null,
                ],
            ]);

        $searchedUser->forceDelete();
    }

    public function testAdminCannotFindNonExistingUsers(): void
    {
        $admin        = factory(User::class)->make(['is_admin' => 1]);
        $searchedUser = factory(User::class)->make(['first_name' => 'test@user', 'team_id' => null]);

        $response = $this->actingAs($admin)->getJson("admin/find-user?term={$searchedUser->first_name}");
        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCannotFindUserIfInTeam()
    {
        $admin        = factory(User::class)->make(['is_admin' => 1]);
        $searchedUser = factory(User::class)->create(['first_name' => 'test', 'team_id' => Team::first()->id]);

        $response = $this->actingAs($admin)->getJson("admin/find-user?term={$searchedUser->first_name}");
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson([]);
        $searchedUser->forceDelete();
    }

    public function testFindUserValidation(): void
    {
        $admin    = factory(User::class)->make(['is_admin' => 1]);
        $route    = route('admin.find_user', ['term']);
        $response = $this->actingAs($admin)->getJson($route);
        $response->assertJsonValidationErrors(['term' => 'The term field is required.']);
        $response->assertUnprocessable();
    }

    public function testCanAddUserRole()
    {
        $admin  = factory(User::class)->make(['is_admin' => 1]);
        $user   = factory(User::class)->create(['role_id' => null]);
        $roleId = Role::first()->value('id');

        $route    = route('admin.change_role', ['user' => $user->id, 'role' => $roleId]);
        $response = $this->actingAs($admin)->postJson($route, ['user' => $user->id, 'role' => $roleId]);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertTrue(json_decode($response->getContent()) == 'new role');
        $user->forceDelete();
    }

    public function testCanChangeUserRole()
    {
        $admin   = factory(User::class)->make(['is_admin' => 1]);
        $oldRole = Role::TRAINER;
        $newRole = Role::COMPETITOR;
        $user    = factory(User::class)->create(['role_id' => $oldRole, 'team_id' => null]);

        $route    = route('admin.change_role', ['user' => $user->id, 'role' => $newRole]);
        $response = $this->actingAs($admin)->postJson($route, ['user' => $user->id, 'role' => $newRole]);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertTrue(json_decode($response->getContent()) == 'new role');
        $user->forceDelete();
    }

    public function testCantChangeUserRoleWithSameRole()
    {
        $admin   = factory(User::class)->make(['is_admin' => 1]);
        $oldRole = Role::TRAINER;
        $newRole = Role::TRAINER;
        $user    = factory(User::class)->create(['role_id' => $oldRole, 'team_id' => null]);

        $route    = route('admin.change_role', ['user' => $user->id, 'role' => $newRole]);
        $response = $this->actingAs($admin)->postJson($route, ['user' => $user->id, 'role' => $newRole]);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $this->assertTrue(json_decode($response->getContent()) == 'no role');
        $user->forceDelete();
    }

    public function testCantChangeUserRole(): void
    {
        $admin = factory(User::class)->make(['is_admin' => 1]);
        $user  = User::firstWhere('role_id', null);

        foreach ($this->invalidCases() as $case) {
            $route    = route('admin.change_role', ['user' => $user->id, 'role' => $case['role']]);
            $response = $this->actingAs($admin)->postJson($route, ['user' => $user->id, 'role' => $case['role']]);
            $response->assertJsonValidationErrors(['role' => $case['error']]);
            $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

            $this->assertTrue(!$user->role_id);
        }
    }

    private function invalidCases(): array
    {
        return [
            [
                'role'  => Role::orderByDesc('id')->first()->value('id') + 1,
                'error' => 'The selected role is invalid.',
            ],
            [
                'role'  => 'abv',
                'error' => 'The role must be an integer.',
            ],
        ];
    }
}
