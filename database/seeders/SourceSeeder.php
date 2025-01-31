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
            ],
            [
                'name' => 'Sentir es el Secreto',
                'source_type_id' => 2,
            ],
            [
                'name' => 'El Poder de la Conciencia',
                'source_type_id' => 3,
            ],
            [
                'name' => 'El Secreto de la Imaginación',
                'source_type_id' => 4,
            ],
        ];

        DB::table('sources')->insert($sources);
    }
}
