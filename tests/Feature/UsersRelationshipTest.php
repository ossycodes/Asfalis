<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Emergencycontacts;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersRelationshipTest extends TestCase
{
    use RefreshDatabase, WithoutEvents;

    /** @test */
    public function it_returns_a_relationship_to_emergencycontacts_adhering_to_json_api_spec()
    {
        $this->markTestSkipped();
        
        $user = factory(User::class)->create();
        $token = auth()->tokenById($user->id);

        $emergencycontacts = factory(Emergencycontacts::class, 2)->create();

        $this->getJson(route('profile'), [
            "accept" =>  "application/vnd.api+json",
            "Authorization" => "Bearer {$token}"
        ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => '1',
                    'type' => 'users',
                    'relationships' => [
                        'emergencycontacts' => [
                            'links' => [
                                'self' => route(
                                    'users.relationships.emergencycontacts',
                                    ['id' => $user->id]
                                ),
                                'related' => route(
                                    'user.emergencycontacts'
                                ),
                            ],
                        ]
                    ]
                ],
                'included' => [
                    [
                        "id" => '1',
                        "type" => "emergencycontacts",
                        "attributes" => [
                            'name' => $emergencycontacts[0]->name,
                            'email' => $emergencycontacts[0]->email,
                            'phone_number' => $emergencycontacts[0]->phonenumber,
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "emergencycontacts",
                        "attributes" => [
                            'name' => $emergencycontacts[1]->name,
                            'email' => $emergencycontacts[1]->email,
                            'phone_number' => $emergencycontacts[1]->phonenumber,
                        ]
                    ],
                ]
            ]);
    }
}
