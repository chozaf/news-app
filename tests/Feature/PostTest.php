<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_posts_exists(): void
    {
        $response = $this->get('api/en/posts');
        $response->assertStatus(200);

        $response = $this->get('api/ua/posts');
        $response->assertStatus(200);

        $response = $this->get('api/ru/posts');
        $response->assertStatus(200);
    }

    public function test_random_post_show(): void
    {
        $post = Post::inRandomOrder()->first();
        $response = $this->get('api/ru/posts/' . $post->id);
        $response->assertStatus(200);

        $post = Post::inRandomOrder()->first();
        $response = $this->get('api/en/posts/' . $post->id);
        $response->assertStatus(200);

        $post = Post::inRandomOrder()->first();
        $response = $this->get('api/ua/posts/' . $post->id);
        $response->assertStatus(200);
    }

    public function test_post_create(): void
    {
        $postData = [
            "title"         => 'my title',
            "description"   => 'my description',
            "content"       => "my content",
        ];

        $this->json('POST', 'api/ua/posts/', $postData)
            ->assertStatus(201)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "title",
                    "description",
                    "content",
                    "language_id",
                    "tags"
                ]
            ])
            ->assertJsonPath('data.title', 'my title');
    }


    public function test_post_update(): void
    {

        app()->setLocale('ua');
        $post = Post::query()->first();

        $this->put('api/ua/posts/'. $post->id,['title'=>'another title'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "title",
                    "description",
                    "content",
                    "language_id",
                    "tags"
                ]
            ])
            ->assertJsonPath('data.title', 'another title');
    }

    public function test_post_delete(): void
    {

        app()->setLocale('ua');
        $post = Post::query()->first();

        $this->delete('api/ua/posts/' . $post->id)
            ->assertStatus(200);

        $this->delete('api/ua/posts/' . $post->id)
            ->assertStatus(404);

    }
}
