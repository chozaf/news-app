<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Database\Eloquent\Factories\Sequence;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()
            ->hasPosts(3)
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
            ->count(10)

            ->state(new Sequence(
                fn (Sequence $sequence) => ['name' => fake()->colorName()],
            ))
            ->create();
    }
}
