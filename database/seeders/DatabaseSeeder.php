<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $sam = User::factory()->create([
            'name' => 'Sam',
            'email' => 'sam@example.com',
        ]);

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SourceTypesSeeder::class,
            QuotesSeeder::class,
        ]);

        $sam->assignRole('super-admin');
    }
}
