<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceTypes = [
            ['name' => 'Conferencia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Libro', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Entrevista', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Artículo', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('source_types')->insertOrIgnore($sourceTypes);
    }
}
