<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Prospect', 'Lead', 'Customer', 'Partner'];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
        }

        $categoryIds = Category::pluck('id')->toArray();

        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory()->count(5)->create();
        }

        Client::factory()->count(30)->create([
            'category_id' => fn() => fake()->randomElement($categoryIds),
            'user_id' => fn() => fake()->randomElement($users->pluck('id')->toArray()),
        ]);
    }
}
