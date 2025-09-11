<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Branch;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Item::factory()
            ->count(10)
            ->create();

        Branch::factory()->create([
            'status' => 1,
        ]);
    }
}
