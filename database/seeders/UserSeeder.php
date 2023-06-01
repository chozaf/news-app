<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'name'              => 'Dima',
            'email'             => 'chozaf@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('chozaf@gmail.com'),
            'remember_token'    => Str::random(10),
        ]);
    }

}
