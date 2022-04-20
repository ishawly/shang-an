<?php

namespace Tests\Feature\Traits;

use App\Models\User;

trait MockApiUser
{
    protected function getAnApiUser()
    {
        User::factory(1)->create();

        return User::first();
    }

    protected function getAnAccessToken()
    {
        User::factory(1)->create();
        $user = User::first();
        auth()->login($user);

        $user = auth()->user();

        return $user->createToken('api')->plainTextToken;
    }

    protected function setAuthenticationHeader()
    {
        $token = $this->getAnAccessToken();
        $this->withHeader('Authentication', 'Bearer ' . $token);
    }
}
