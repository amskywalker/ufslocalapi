<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_be_able_to_login_with_correct_credentials()
    {
        $user = User::factory()->create();

        $userData = $user->toArray();
        $userData['password'] = 'password';

        $response = $this->post('/api/login', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token'
                ]
            ])->assertJson([
                'message' => 'Login successful'
            ]);
    }

    /**
     * @test
     */
    public function should_not_be_able_to_login_with_correct_credentials()
    {
        $response = $this->post('/api/login', [
            'email' => 'test@test.com.br',
            'password' => 'wrongpasswordtest'
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])->assertJson([
                'status' => 'Error',
                'message' => 'Credentials not match'
            ]);
    }
}
