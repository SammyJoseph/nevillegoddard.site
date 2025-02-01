<?php

namespace Database\Seeders;

use App\Models\Source;
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
        $sources = Source::all();
        $quotes = [
            [
                'quote' => 'La imaginación es el poder redentor del universo.',
                'bible_verse' => 'Hebreos 11:1',
                'source_id' => $sources->random()->id,
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'quote' => 'No hay límites para lo que puedes lograr, excepto los límites que te impones.',
                'bible_verse' => 'Marcos 9:23',
                'source_id' => $sources->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('quotes')->insert($quotes);
    }
}
