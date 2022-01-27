<?php

namespace Tests\Feature;

use App\Enums\Menu;
use App\Models\Admin\Settlement;
use App\Models\Admin\Sport;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserTest extends TestCase
{
    /*
     * Before test testUserCannotViewLoginFormWhenAuthenticated() and testUserCanLoginWithCorrectCredentials() methods
     * go to database/factories/UserFactory.php and comment line 22 and set
     * 'settlement_id' => 1,
     * 'sport_id'      => 1,
     */

    public function testLogin(): void
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
        $this->view('auth.login', ['activeMenu' => Menu::LOGIN->value, 'activeSubMenu' => collect()]);
    }

    public function testUserCannotViewLoginFormWhenAuthenticated(): void
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/welcome');
        $response->assertStatus(ResponseAlias::HTTP_FOUND);
    }

    public function testUserCanLoginWithCorrectCredentials(): void
    {
        $user = factory(User::class)->create([
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);
        $response->assertJson(['route' => route('welcome')]);
        $this->assertAuthenticatedAs($user);
        $user->forceDelete();
    }

    public function testUserCannotLoginWithWrongPassword(): void
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
        $response->assertStatus(ResponseAlias::HTTP_FOUND);
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
        $user->forceDelete();
    }

    public function testRegister()
    {
        $response = $this->get('/register');

        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
        $this->view('auth.register', ['activeMenu' => Menu::REGISTER->value, 'activeSubMenu' => collect()]);
    }

    public function testUserCannotViewRegisterFormWhenAuthenticated(): void
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/register');
        $response->assertRedirect('/welcome');
        $response->assertStatus(ResponseAlias::HTTP_FOUND);
    }

    public function testCanRegisterWithCorrectData()
    {
        $settlement = Settlement::with('sports')->first();
        $sport      = $settlement->sports->first();

        $response = $this->postJson('/store', [
            'first_name'            => 'Joe',
            'last_name'             => 'Doe',
            'email'                 => 'joe_doe@joe.com',
            'settlement_id'         => $settlement->id,
            'sport_id'              => $sport->id,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(ResponseAlias::HTTP_OK);

        $newUser = User::where('full_name', 'Joe Doe')->first();

        $this->assertTrue($newUser->exists);
        $newUser->forceDelete();
    }

    public function testWelcomePage()
    {
        $user = factory(User::class)->make(['team_id' => null]);
        $view = $this->actingAs($user)
                     ->view('home', ['activeMenu' => Menu::WELCOME->value, 'activeSubMenu' => collect()]);

        $view->assertSee('You are still not distributed for a team');
    }

    public function testInvalidRegistration()
    {
        foreach ($this->registrationInvalidCases() as $case) {
            $response = $this->postJson('/store', [
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
    }

    private function registrationInvalidCases(): array
    {
        $settlement = Settlement::with('sports')->first();
        $sport      = $settlement->sports->first();

        return [
            [ // all fields are required
              'first_name'            => '',
              'last_name'             => '',
              'email'                 => '',
              'settlement_id'         => '',
              'sport_id'              => '',
              'password'              => '',
              'password_confirmation' => '',
              'errors'                => [
                  'first_name'    => 'Field is required',
                  'last_name'     => 'Field is required',
                  'email'         => 'Field is required',
                  'settlement_id' => 'Field is required',
                  'sport_id'      => 'Field is required',
                  'password'      => 'Field is required',
              ],
            ],
            [ // first_name, last_name, password, password_confirmation are string
              'first_name'            => 12,
              'last_name'             => 34,
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 11111111,
              'password_confirmation' => 11111111,
              'errors'                => [
                  'first_name' => 'The first name must be a string.',
                  'last_name'  => 'The last name must be a string.',
                  'password'   => 'The password must be a string.',

              ],
            ],
            [ // first_name, last_name max length 50
              'first_name'            => Str::random(51),
              'last_name'             => Str::random(51),
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 'password',
              'password_confirmation' => 'password',
              'errors'                => [
                  'first_name' => 'The first name may not be greater than 50 characters.',
                  'last_name'  => 'The last name may not be greater than 50 characters.',
              ],
            ],
            [ // settlement and sport exists
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => Settlement::orderByDesc('id')->value('id') + 1,
              'sport_id'              => Sport::orderByDesc('id')->value('id') + 1,
              'password'              => 'password',
              'password_confirmation' => 'password',
              'errors'                => [
                  'settlement_id' => 'There is no such a value',
                  'sport_id'      => 'There is no such a value',
              ],
            ],
            [ // settlement and sport do not exist within relation
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $settlement->sports()->orderByDesc('id')->first()->id + 1,
              'password'              => 'password',
              'password_confirmation' => 'password',
              'errors'                => [
                  'sport_id' => 'There is no such a value',
              ],
            ],
            [ // invalid email
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'joe_doejoe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 'password',
              'password_confirmation' => 'password',
              'errors'                => [
                  'email' => 'The email must be a valid email address.',
              ],
            ],
            [ // unique email
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'denis@test.bg',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 'password',
              'password_confirmation' => 'password',
              'errors'                => [
                  'email' => 'The email has already been taken.',
              ],
            ],
            [ // password min length
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 'passwor',
              'password_confirmation' => 'passwor',
              'errors'                => [
                  'password' => 'The password must be at least 8 characters.',
              ],
            ],
            [ // password miss match
              'first_name'            => 'Joe',
              'last_name'             => 'Doe',
              'email'                 => 'joe_doe@joe.com',
              'settlement_id'         => $settlement->id,
              'sport_id'              => $sport->id,
              'password'              => 'password',
              'password_confirmation' => 'password1',
              'errors'                => [
                  'password' => 'The password confirmation does not match.',
              ],
            ],
        ];
    }
}
