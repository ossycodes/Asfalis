<?php

namespace Tests\Feature;

use App\News;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_news_as_a_collection_of_resource_objects()
    {
        $news = factory(News::class, 3)->create();

        $url = route('news.all');

        $response = $this->getJson($url);

        $response->assertJson([
            "data" => [
                [
                    "id" => '1',
                    "type" => "news",
                    "attributes" => [
                        "title" => $news[0]->title,
                        "description" => $news[0]->description,
                        "body" => $news[0]->body
                    ]
                ],
                [
                    "id" => '2',
                    "type" => "news",
                    "attributes" => [
                        "title" => $news[1]->title,
                        "description" => $news[1]->description,
                        "body" => $news[1]->body
                    ]
                ],
                [
                    "id" => '3',
                    "type" => "news",
                    "attributes" => [
                        "title" => $news[2]->title,
                        "description" => $news[2]->description,
                        "body" => $news[2]->body
                    ]
                ]
            ]
        ]);
        $response->assertOk();
    }

    /** @test */
    public function it_returns_a_news_as_a_resource_object()
    {
        $news = factory(News::class)->create();
  
        $uri = route("news.show", ["id" => 1]);

        $this->getJson($uri)
            ->assertOk()
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "type" => "news",
                    "attributes" => [
                        // "title" => $news->title,
                        "description" => $news->description,
                        "body" => $news->body
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_create_a_news_from_a_resource_object()
    {
        $uri = route('news.store');

        $newsAttributes = factory(News::class)->raw();

        $news = ["data" => [
            "type" => "news",
            "attributes" => $newsAttributes
        ]];

        $response = $this->postJson($uri, $news);

        $response->assertStatus(201)
            ->assertJson([
                "data" => [
                    "id" => 1,
                    "type" => "news",
                    "attributes" => [
                        "title" => $newsAttributes["title"],
                        "description" => $newsAttributes["description"],
                        "body" => $newsAttributes["body"]
                    ]
                ]
            ]);

        $this->assertDatabaseHas('news', $newsAttributes);
    }

    /** @test */
    public function it_can_update_a_news_from_a_resource_object()
    {

        $oldNews = factory(News::class)->create([
            "title" => "old news",
            "description" => "old news description",
            "body" => "old news body"
        ]);

        $uri = route('news.update', ["id" => $oldNews->id]);

        $updatedNewsAttributes = factory(News::class)->raw();

        $updatedNews = ["data" => [
            "id" => (string) $oldNews->id,
            "type" => "news",
            "attributes" => $updatedNewsAttributes
        ]];

        $response = $this->patchJson($uri, $updatedNews);

        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => '1',
                    "type" => "news",
                    "attributes" => [
                        "title" => $updatedNewsAttributes["title"],
                        "description" => $updatedNewsAttributes["description"],
                        "body" => $updatedNewsAttributes["body"]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing("news", $oldNews->toArray());
        $this->assertDatabaseHas('news', $updatedNewsAttributes);
    }

    /** @test */
    public function it_validate_that_type_member_is_given_when_creating_news()
    {
        $newsAttributes = factory(News::class)->raw();

        $news = [
            "data" => [
                "type" => "",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'title' =>  $newsAttributes["title"]
        ]);
    }

    /** @test */
    public function it_validates_that_the_type_member_has_the_value_of_news_when_creating_an_news()
    {
        $newsAttributes = factory(News::class)->raw();

        $news = [
            "data" => [
                "type" => "wrongtype",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'title' =>  $newsAttributes["title"]
        ]);
    }


    /** @test */
    public function it_validates_that_the_attributes_member_has_been_given_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw();

        $news = [
            "data" => [
                "type" => "news",
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'title' =>  $newsAttributes["title"]
        ]);
    }

    /** @test */
    public function it_validates_that_the_attributes_member_is_an_object_given_when_creating_an_news()
    {
        $newsAttributes = factory(News::class)->raw();

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => "i am not an object but a string, so what?"
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'title' =>  $newsAttributes["title"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_title_attribute_is_given_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "title" => ""
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.title field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/title',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'description' =>  $newsAttributes["description"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_description_attribute_is_given_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "description" => ""
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.description field is required.',
                        'source' => [
                            'pointer' => '/data/attributes/description',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'title' =>  $newsAttributes["title"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_body_attribute_is_given_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "body" => ""
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'description' =>  $newsAttributes["description"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_title_attribute_is_a_string_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "title" => 123
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.title must be a string.',
                        'source' => [
                            'pointer' => '/data/attributes/title',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'description' =>  $newsAttributes["description"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_description_attribute_is_a_string_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "description" => 123
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.attributes.description must be a string.',
                        'source' => [
                            'pointer' => '/data/attributes/description',
                        ]
                    ]
                ]
            ]);

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'description' =>  $newsAttributes["description"]
        ]);
    }

    /** @test */
    public function it_validates_that_a_body_attribute_is_a_string_when_creating_a_news()
    {
        $newsAttributes = factory(News::class)->raw([
            "body" => 123
        ]);

        $news = [
            "data" => [
                "type" => "news",
                "attributes" => $newsAttributes
            ]
        ];

        $uri = route('news.store');

        $this->postJson($uri, $news)
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

        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'body' =>  $newsAttributes["body"]
        ]);
    }

    /** @test */
    public function it_validates_that_an_id_member_is_given_when_updating_an_author()
    {
        $oldNews = factory(News::class)->create();

        $updatedNewsAttributes = factory(News::class)->raw();

        $updatedNews = [
            "data" => [
                "type" => "news",
                "attributes" => $updatedNewsAttributes
            ]
        ];

        $uri = route('news.update', ["id" => $oldNews->id]);

        $this->patchJson($uri, $updatedNews)
            ->assertStatus(422)
            ->assertJson([
                "errors" => [
                    [
                        'title' => 'Validation Error',
                        'details' => 'The data.id field is required.',
                        'source' => [
                            'pointer' => '/data/id',
                        ]
                    ]
                ]
            ]);


        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'body' =>  $updatedNewsAttributes["body"]
        ]);
    }

    /** @test */
    public function it_validates_that_an_id_member_given_is_a_string_when_updating_an_author()
    {
        $oldNews = factory(News::class)->create();

        $updatedNewsAttributes = factory(News::class)->raw();

        $updatedNews = [
            "data" => [
                "id" => 1,
                "type" => "news",
                "attributes" => $updatedNewsAttributes
            ]
        ];

        $uri = route('news.update', ["id" => $oldNews->id]);

        $this->patchJson($uri, $updatedNews)
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


        $this->assertDatabaseMissing('news', [
            'id' => 1,
            'body' =>  $updatedNewsAttributes["body"]
        ]);
    }

    /** @test */
    public function it_can_delete_a_news()
    {
        $news = factory(News::class)->create();

        $uri = route('news.destroy', ['id' => $news->id]);

        $this->deleteJson($uri)
            ->assertStatus(204);
    }
}
