<?php

namespace Tests\Feature;

use App\Tips;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_tips_as_a_collection_of_resource_objects()
    {
        $tips = factory(Tips::class, 3)->create();

        $url = route('tips.all');

        $response = $this->getJson($url);

        $response->assertJson([
            "data" => [
                [
                    "id" => '1',
                    "type" => "tips",
                    "attributes" => [
                        "body" => $tips[0]->body,
                    ]
                ],
                [
                    "id" => '2',
                    "type" => "tips",
                    "attributes" => [
                        "body" => $tips[1]->body,
                    ]
                ],
                [
                    "id" => '3',
                    "type" => "tips",
                    "attributes" => [
                        "body" => $tips[2]->body,
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }

    /** @test */
    public function it_returns_a_tip_as_a_resource_object()
    {
        $tip = factory(Tips::class)->create();

        $uri = route("tip.show", ["id" => 1]);

        $this->getJson($uri)
            ->assertOk()
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "type" => "tips",
                    "attributes" => [
                        "body" => $tip->body
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_tip_from_a_resource_object()
    {
        $uri = route('tip.store');

        $tipAttributes = factory(Tips::class)->raw();

        $tip = ["data" => [
            "type" => "tips",
            "attributes" => $tipAttributes
        ]];

        $response = $this->postJson($uri, $tip);

        $response->assertStatus(201)
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "type" => "tips",
                    "attributes" => [
                        "body" => $tipAttributes["body"]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('tips', $tipAttributes);
    }

    /** @test */
    public function it_can_update_a_tip_from_a_resource_object()
    {

        $oldTip = factory(Tips::class)->create([
            "body" => "old tip body"
        ]);

        $uri = route('tip.update', ["id" => $oldTip->id]);

        $updatedTipAttributes = factory(Tips::class)->raw();

        $updatedTip = ["data" => [
            "id" => (string) $oldTip->id,
            "type" => "tips",
            "attributes" => $updatedTipAttributes
        ]];

        $response = $this->patchJson($uri, $updatedTip);

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => '1',
                    "type" => "tips",
                    "attributes" => [
                        "body" => $updatedTipAttributes["body"]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing("tips", $oldTip->toArray());
        $this->assertDatabaseHas('tips', $updatedTipAttributes);
    }

    /** @test */
    public function it_validate_that_type_member_is_given_when_creating_tip()
    {
        $tipAttributes = factory(Tips::class)->raw();

        $tip = [
            "data" => [
                "type" => "",
                "attributes" => $tipAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.type field is required.',
                        'source' => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipAttributes["body"]
        ]);
    }

    /** @test */
    public function it_validates_that_the_type_member_has_the_value_of_tips_when_creating_an_tip()
    {
        $tipsAttributes = factory(Tips::class)->raw();

        $tip = [
            "data" => [
                "type" => "wrongtype",
                "attributes" => $tipsAttributes
            ]
        ];

        $uri = route('tip.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The selected data.type is invalid.',
                        'source' => [
                            'pointer' => '/data/type',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipsAttributes["body"]
        ]);
    }


    /** @test */
    public function it_validates_that_the_attributes_member_has_been_given_when_creating_a_tip()
    {
        $tipAttributes = factory(Tips::class)->raw();

        $tip = [
            "data" => [
                "type" => "tips",
            ]
        ];

        $uri = route('tip.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes field is required.',
                        'source' => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipAttributes["body"]
        ]);
    }

    /** @test */
    public function it_validates_that_the_attributes_member_is_an_object_given_when_creating_an_tip()
    {
        $tipAttributes = factory(Tips::class)->raw();

        $tip = [
            "data" => [
                "type" => "tips",
                "attributes" => "i am not an object but a string, so what?"
            ]
        ];

        $uri = route('tip.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes must be an array.',
                        'source' => [
                            'pointer' => '/data/attributes',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipAttributes["body"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_body_attribute_is_given_when_creating_a_tip()
    {
        $tipsAttributes = factory(Tips::class)->raw([
            "body" => ""
        ]);

        $tip = [
            "data" => [
                "type" => "tips",
                "attributes" => $tipsAttributes
            ]
        ];

        $uri = route('tip.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.body field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/body',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipsAttributes["body"]
        ]);
    }



    /** @test */
    public function it_validates_that_a_body_attribute_is_a_string_when_creating_a_tip()
    {
        $tipAttributes = factory(Tips::class)->raw([
            "body" => 123
        ]);

        $tip = [
            "data" => [
                "type" => "tips",
                "attributes" => $tipAttributes
            ]
        ];

        $uri = route('tip.store');

        $this->postJson($uri, $tip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.body must be a string.',
                        'source' => [
                            'pointer' => '/data/attributes/body',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $tipAttributes["body"]
        ]);
    }


    /** @test */
    public function it_validates_that_an_id_member_given_is_a_string_when_updating_an_author()
    {
        $oldTip = factory(Tips::class)->create();

        $updatedTipsAttributes = factory(Tips::class)->raw();

        $updatedTip = [
            "data" => [
                "id" => 1,
                "type" => "tips",
                "attributes" => $updatedTipsAttributes
            ]
        ];

        $uri = route('tip.update', ["id" => $oldTip->id]);

        $this->patchJson($uri, $updatedTip)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.id must be a string.',
                        'source' => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);


        $this->assertDatabaseMissing('tips', [
            'id' => 1,
            'body' =>  $updatedTipsAttributes["body"]
        ]);
    }
    
    /** @test */
    public function it_can_delete_a_tip()
    {
        $tip = factory(Tips::class)->create();

        $uri = route('tip.destroy', ['id' => $tip->id]);

        $this->deleteJson($uri)
            ->assertStatus(204);
    }
}
