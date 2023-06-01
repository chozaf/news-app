<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Tag;


use App\Models\TagTranslation;
use App\Models\User;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\PostSeeder;


use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            PostSeeder::class,
        ]);

    }
}
