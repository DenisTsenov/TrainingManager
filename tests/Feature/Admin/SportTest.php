<?php

namespace Tests\Feature\Admin;

use App\Enums\Menu;
use App\Models\Admin\Sport;
use App\Models\User;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanAccessWithAdminUser(): void
    {
        $admin    = User::firstWhere('is_admin', true);
        $response = $this->actingAs($admin)->get('/admin/sport/create');

        $response->assertViewIs('auth.admin.sports.create_edit');

        $this->view('auth.admin.sports.create_edit', [
            'route'         => route('admin.sport.store'),
            'setActiveMenu' => Menu::ADMIN->value,
            'activeSubMenu' => collect([Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORT_CREATE_EDIT->value]),
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCannotBeAccessedByNoAdmin(): void
    {
        $user     = User::firstWhere('is_admin', false);
        $response = $this->actingAs($user)->get('/admin/sport/create');

        $response->assertStatus(ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function testCanCreateSport(): void
    {
        $admin = User::firstWhere('is_admin', true);

        $response = $this->actingAs($admin)->post('/admin/sport/store', ['name' => 'SkiingTestSport']);

        $response->assertSessionDoesntHaveErrors(['name' => 'The name field is required.']);
        $response->assertSessionHas(['success' => 'Operation done successfully!']);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['route' => route('admin.sport')]);

        $this->assertDatabaseHas('sports', ['name' => 'SkiingTestSport']);

        \DB::table('sports')->where('name', 'SkiingTestSport')->delete();

        $this->assertDatabaseMissing('sports', ['name' => 'SkiingTestSport']);
    }

    public function testCanAccessEditWithAdminUser(): void
    {
        $admin    = User::firstWhere('is_admin', true);
        $sport    = Sport::first();
        $route    = route('admin.sport.edit', [$sport->id]);
        $response = $this->actingAs($admin)->get($route);

        $response->assertViewIs('auth.admin.sports.create_edit');

        $this->view('auth.admin.sports.create_edit', [
            'route'         => route('admin.sport.update', ['sport' => $sport]),
            'setActiveMenu' => Menu::ADMIN->value,
            'activeSubMenu' => collect([Menu::SUB_MENU_SPORTS->value, Menu::SUB_MENU_SPORT_CREATE_EDIT->value]),
            'sport'         => $sport,
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCanEditSport(): void
    {
        $admin = User::firstWhere('is_admin', true);
        $sport = Sport::first(); // Weightlifting
        $route = route('admin.sport.update', ['sport' => $sport]);

        $response = $this->actingAs($admin)->postJson($route, ['name' => 'Weightlifting2']);

        $response->assertSessionDoesntHaveErrors(['name' => 'The name field is required.']);
        $response->assertSessionHas(['success' => 'Operation done successfully!']);
        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['route' => route('admin.sport')]);

        $this->assertDatabaseMissing('sports', ['name' => 'Weightlifting']);
        $this->assertDatabaseHas('sports', ['name' => 'Weightlifting2']);

        $this->actingAs($admin)->postJson($route, ['name' => 'Weightlifting']); // revert change
    }

    // TODO: 1) test for validation errors, 2)test sport toggle
}
