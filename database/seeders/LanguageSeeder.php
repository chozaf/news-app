<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{

    public function run(): void
    {
        Language::insert([
            ['locale' => 'ua', 'prefix' => 'UA'],
            ['locale' => 'ru', 'prefix' => 'RU'],
            ['locale' => 'en', 'prefix' => 'EN'],
        ]);
    }

}
