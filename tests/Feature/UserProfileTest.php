<?php

namespace Tests\Feature;

use App\Models\Admin\Role;
use App\Models\Admin\Settlement;
use App\Models\Admin\Sport;
use App\Models\Admin\Team;
use App\Models\User;
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

        $this->assertFalse($user->can('deactivateProfile', $user));
        $response = $this->actingAs($user)->postJson("/profile/destroy/$user->id");
        $response->assertStatus(ResponseAlias::HTTP_FORBIDDEN);
        $user->forceDelete();
        $team->forceDelete();
    }

    public function testCanEditProfile()
    {
        $user = factory(User::class)->create(['team_id' => null]);

        $requestData = [
            'first_name'            => 'Denis',
            'last_name'             => 'Tsenov',
            'email'                 => 'some@test.bg',
            'sport_id'              => \DB::table('sports')->inRandomOrder()->first()->id,
            'settlement_id'         => \DB::table('settlements')->inRandomOrder()->first()->id,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->actingAs($user)->putJson("profile/$user->id/update", $requestData);
        $response->assertStatus(ResponseAlias::HTTP_NO_CONTENT);
        $user->forceDelete();
    }

    public function testCannotEditProfile()
    {

    }

    private function teamId(User $user = null): int
    {
        $trainer    = $user ?? User::firstWhere('role_id', Role::TRAINER);
        $sport      = $this->getSport($trainer->sport_id);
        $settlement = $this->getSettlement($trainer->settlement_id);

        return \DB::table('teams')->insertGetId([
            'name'          => 'Test',
            'trainer_id'    => $trainer->id,
            'sport_id'      => $sport->id,
            'settlement_id' => $settlement->id,
            'created_by'    => $trainer->id,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    private function getSettlement(int $settlementId): Sport
    {
        return Sport::find($settlementId);
    }

    private function getSport(int $sportId): Settlement
    {
        return Settlement::find($sportId);
    }
}
