<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTranslation;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\TagTranslation;

class PostSeeder extends Seeder
{

    public function run(): void
    {
        Post::factory()
        ->has(
            Tag::factory()
           // ->hasPosts(3)
            ->has(
                TagTranslation::factory()
                    ->state(new Sequence(
                        ['language_id' => 1],
                        ['language_id' => 2],
                        ['language_id' => 3],
                    ))
                    ->state(function (array $attributes, Tag $tag) {

                        $locales = ['ua_UA', 'ru_RU', 'en_EN'];
                        $faker = \Faker\Factory::create($locales[$attributes['language_id'] - 1]);

                        return [
                            'tag_id' => $tag->id,
                            'title' => $faker->colorName()
                        ];
                    })
                    ->count(3)
            )
            ->count(3)
        )
            ->has(
                PostTranslation::factory()
                ->count(3)
                ->state(new Sequence(
                    ['language_id' => 1],
                    ['language_id' => 2],
                    ['language_id' => 3],
                ))
                ->state(function (array $attributes, Post $post) {
                    $locales = ['ua_UA','ru_RU','en_EN'];
                    $faker = \Faker\Factory::create($locales[$attributes['language_id']-1]);
                    return [
                        'post_id' => $post->id,
                        'title' => $faker->country(),
                        'description' => $faker->sentence(10),
                        'content' => $faker->text(),
                    ];
                })
            )
            ->count(20)
            ->create();
    }
}
