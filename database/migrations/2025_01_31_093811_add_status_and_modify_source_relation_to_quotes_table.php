<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear la tabla 'sources'
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('source_type_id');
            $table->foreign('source_type_id')->references('id')->on('source_types');
            $table->timestamps();
        });

        // Migrar datos existentes de 'quotes' a 'sources'
        $quotes = DB::table('quotes')->select('source', 'source_type_id')->distinct()->get();
        foreach ($quotes as $quote) {
            DB::table('sources')->insertOrIgnore([
                'name' => $quote->source,
                'source_type_id' => $quote->source_type_id,
            ]);
        }

        // Modificar la tabla 'quotes'
        Schema::table('quotes', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('bible_verse');
            $table->unsignedBigInteger('source_id')->nullable()->after('status');
            $table->foreign('source_id')->references('id')->on('sources');
        });

        // Actualizar 'source_id' en 'quotes' basado en 'source' y 'source_type_id'
        $quotes = DB::table('quotes')->get();
        foreach ($quotes as $quote) {
            $source = DB::table('sources')
                ->where('name', $quote->source)
                ->where('source_type_id', $quote->source_type_id)
                ->first();

            if ($source) {
                DB::table('quotes')
                    ->where('id', $quote->id)
                    ->update(['source_id' => $source->id]);
            }
        }

        // Eliminar columnas antiguas de 'quotes'
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropForeign(['source_type_id']);
            $table->dropColumn('source_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('source')->nullable();
            $table->unsignedBigInteger('source_type_id')->nullable();
            $table->foreign('source_type_id')->references('id')->on('source_types');
        });

        // Restaurar datos de 'sources' a 'quotes'
        $quotes = DB::table('quotes')->get();
        foreach ($quotes as $quote) {
            $source = DB::table('sources')->find($quote->source_id);
            if ($source) {
                DB::table('quotes')
                    ->where('id', $quote->id)
                    ->update([
                        'source' => $source->name,
                        'source_type_id' => $source->source_type_id
                    ]);
            }
        }

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table->dropColumn('source_id');
            $table->dropColumn('status');
        });

        Schema::dropIfExists('sources');
    }
};
