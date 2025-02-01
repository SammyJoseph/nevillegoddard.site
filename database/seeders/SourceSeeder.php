<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'La Ley y la Promesa',
                'source_type_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sentir es el Secreto',
                'source_type_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'El Poder de la Conciencia',
                'source_type_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'El Secreto de la Imaginación',
                'source_type_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('sources')->insert($sources);
    }
}
