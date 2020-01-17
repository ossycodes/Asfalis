<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutEvents;

class UserTest extends TestCase
{
    use RefreshDatabase, WithoutEvents;

    /** @test */
    public function it_can_register_a_user()
    {
        $this->withoutExceptionHandling();
        $userDetails = [
            "data" => [
                "type" => "users",
                "attributes" => [
                    "first_name" => "test",
                    "last_name" => "test",
                    "email" => "test@gmail.com",
                    "phonenumber" => "08088888888",
                    "password" => "ssss"
                ]
            ]
        ];

        $uri = route('auth.register');
        $this->postJson($uri, $userDetails, [
            "content-type" => "application/vnd.api+json",
            "accept" => "application/vnd.api+json"
        ])
            ->assertStatus(201); 
    }

    
}
