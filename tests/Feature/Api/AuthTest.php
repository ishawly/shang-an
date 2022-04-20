<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Traits\MockApiUser;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use MockApiUser, WithFaker;

    private string $baseUrl = '/api/auth';

    public function test_auth_login()
    {
        $user = $this->getAnApiUser();
        $credentials = [
            "email" => $user->email,
            "password" => 'password',
        ];

        $response = $this->postJson($this->baseUrl . '/login', $credentials);
        $response->assertStatus(200)
            ->assertSee('message')
            ->assertSeeText('message')
            ->assertJson([
                'code' => 0,
                'data' => [
                    'token_type' => 'bearer',
                ]
            ]);
        $response->assertJsonStructure([
            'code',
            'message',
            'data' => [
                'access_token',
                'token_type',
            ]
        ]);
        $response->assertJson(
            fn (AssertableJson $json) =>
                $json->whereType('code', 'integer')
                    ->whereType('message', 'string|null')
                    ->whereAllType([
                        'data' => 'array',
                        'data.access_token' => ['string'],
                    ])
        );
    }

    public function test_user_profile()
    {
        $this->setAuthenticationHeader();
        $response = $this->getJson($this->baseUrl . '/user-profile');

        $response->assertSuccessful()->assertJson(['code' => 0]);
        $response->assertJsonStructure([
            'code',
            'message',
            'data' => [
                'id',
                'name',
                'email',
            ]
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json->whereType('data', 'array')
                ->has('data', function (AssertableJson $json) {
                    $json->whereAllType([
                        'id' => 'integer',
                        'name' => 'string',
                        'email' => 'string',
                    ])
                    ->etc();
                })
                ->etc();
        });
    }

    public function test_logout()
    {
        $this->setAuthenticationHeader();
        $response = $this->postJson($this->baseUrl . '/logout');

        $response->assertStatus(200);
    }
}
