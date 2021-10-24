<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
//    use RefreshDatabase;

    /*
     * Before test testUserCannotViewLoginFormWhenAuthenticated() and testUserCanLoginWithCorrectCredentials() methods
     * go to database/factories/UserFactory.php and comment line 22 and set
     * 'settlement_id' => 1,
     * 'sport_id'      => 1,
     */

    public function testLogin()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewLoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
             ->get('/login')
             ->assertRedirect('/welcome');
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertJson(['route' => route('welcome')]);
        $this->assertAuthenticatedAs($user);
        $user->forceDelete();
    }

    public function testUserCannotLoginWithWrongPassword()
    {
        $user = factory(User::class)->create([
            'password' => 'password',
        ]);

        $response = $this->from('/login')
                         ->post('/login', [
                             'email'    => $user->email,
                             'password' => 'invalid-password',
                         ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
        $user->forceDelete();
    }
}
