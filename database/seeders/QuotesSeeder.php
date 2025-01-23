<?php

namespace Database\Seeders;

use App\Models\SourceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source_types = SourceType::all();
        $quotes = [
            [
                'quote' => 'La imaginación es el poder redentor del universo.',
                'bible_verse' => 'Hebreos 11:1',
                'source' => 'La Ley y la Promesa',
                'source_type_id' => $source_types->random()->id,
            ],
            [
                'quote' => 'No hay límites para lo que puedes lograr, excepto los límites que te impones.',
                'bible_verse' => 'Marcos 9:23',
                'source' => 'Sentir es el Secreto',
                'source_type_id' => $source_types->random()->id,
            ],
        ];

        DB::table('quotes')->insert($quotes);
    }
}
