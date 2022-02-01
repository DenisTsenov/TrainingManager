<?php

namespace Tests\Feature;

use App\Models\Admin\Role;
use App\Models\Admin\Settlement;
use App\Models\Admin\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanViewEditAccountPage()
    {
        $user     = factory(User::class)->create();
        $response = $this->actingAs($user)->get('profile/edit');

        $response->assertViewIs('auth.profile');
        $response->assertViewHasAll(['user' => $user, 'destroyRoute' => route('auth.destroy', [$user->id])]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $user->forceDelete();
    }

    public function testUserCanDeleteProfile()
    {
        $user = factory(User::class)->create(['team_id' => null]);

        $this->assertTrue($user->can('deactivateProfile', $user));

        $response = $this->actingAs($user)->post("/profile/destroy/$user->id");
        $response->assertSessionHas('logout', 'Profile disabled successfully!');
        $response->assertJson(['login' => route('login.show')]);
        $response->assertStatus(ResponseAlias::HTTP_OK);

        $user->forceDelete();
    }

    public function testUserCannotDeleteProfile()
    {
        $team = Team::find($this->teamId());
        $user = factory(User::class)->create(['team_id' => $team->id]);

        $this->assertFalse($user->can('deactivateProfile'));
        $response = $this->actingAs($user)->postJson("/profile/destroy/$user->id");
        $response->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
        $user->forceDelete();
        $team->forceDelete();
    }

    public function testCanEditProfile()
    {
        $settlement    = Settlement::with('sports')->first();
        $newSettlement = Settlement::with('sports')->orderByDesc('id')->first();

        $user = factory(User::class)->create([
            'team_id'       => null,
            'settlement_id' => $settlement->id,
            'sport_id'      => $settlement->sports->first()->id,
        ]);

        $this->assertTrue($user->can('deactivateProfile', $user));

        $requestData = [
            'first_name'            => 'Denis',
            'last_name'             => 'Tsenov',
            'email'                 => 'some@test.bg',
            'settlement_id'         => $newSettlement->id,
            'sport_id'              => $newSettlement->sports->first()->id,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->actingAs($user)->putJson("profile/$user->id/update", $requestData);
        $response->assertStatus(ResponseAlias::HTTP_NO_CONTENT);

        $user->refresh();

        $this->assertTrue($user->first_name == $requestData['first_name']);
        $this->assertTrue($user->last_name == $requestData['last_name']);
        $this->assertTrue($user->email == $requestData['email']);
        $this->assertTrue($user->settlement_id == $requestData['settlement_id']);
        $this->assertTrue($user->sport_id == $requestData['sport_id']);
        $this->assertTrue(Hash::check($requestData['password'], $user->password));
        $user->forceDelete();
    }

    private function teamId(): int
    {
        $trainer = User::firstWhere('role_id', Role::TRAINER);

        return \DB::table('teams')->insertGetId([
            'name'          => 'Test',
            'trainer_id'    => $trainer->id,
            'sport_id'      => $trainer->sport_id,
            'settlement_id' => $trainer->settlement_id,
            'created_by'    => $trainer->id,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    public function testInvalidEdit()
    {
        $user = factory(User::class)->create();

        foreach ($this->userInvalidCases() as $case) {
            $response = $this->actingAs($user)->putJson("profile/$user->id/update", [
                'first_name'            => $case['first_name'] ?? '',
                'last_name'             => $case['last_name'] ?? '',
                'email'                 => $case['email'] ?? '',
                'settlement_id'         => $case['settlement_id'] ?? '',
                'sport_id'              => $case['sport_id'] ?? '',
                'password'              => $case['password'] ?? '',
                'password_confirmation' => $case['password_confirmation'] ?? '',
            ]);

            $response->assertJsonValidationErrors($case['errors']);
            $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->forceDelete();
    }

    public function testInvalidSettlementAndSport()
    {
        $team       = Team::find($this->teamId());
        $settlement = Settlement::with('sports')->first();
        $user       = factory(User::class)->create([
            'team_id'       => $team->id,
            'settlement_id' => $settlement->id,
            'sport_id'      => $settlement->sports->first()->id,
        ]);

        $this->assertTrue($user->cannot('deactivateProfile', $user));

        $response = $this->actingAs($user)->putJson("profile/$user->id/update", [
            'first_name'            => 'Joe',
            'last_name'             => 'Doe',
            'email'                 => 'joe@doe.com',
            'settlement_id'         => $settlement->id + 1,
            'sport_id'              => $settlement->sports->first()->id,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertJsonValidationErrors(['sport_id' => 'wrong data']);
        $response->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        $user->forceDelete();
    }
}
