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
            ['name' => 'Conferencia'],
            ['name' => 'Libro'],
            ['name' => 'Entrevista'],
            ['name' => 'Artículo'],
        ];

        DB::table('source_types')->insertOrIgnore($sourceTypes);
    }
}
