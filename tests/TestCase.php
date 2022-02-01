<?php

namespace Tests;

use App\Models\Admin\Settlement;
use App\Models\Admin\Sport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function userInvalidCases(): array
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
