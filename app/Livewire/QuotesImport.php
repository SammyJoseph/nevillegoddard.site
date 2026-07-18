<?php

namespace App\Livewire;

use App\Models\Quote;
use App\Models\Source;
use App\Models\SourceType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\SimpleExcel\SimpleExcelReader;

class QuotesImport extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $sourceName = '';
    public $sourceTypeId = '';
    public $sources = [];
    
    // Results
    public $successCount = 0;
    public $skippedQuotes = [];
    public $errorMessage = '';
    public $isImported = false;

    protected $rules = [
        'csvFile' => 'required|file|mimes:csv,txt|max:10240',
        'sourceName' => 'required|string|min:3',
        'sourceTypeId' => 'required|exists:source_types,id',
    ];

    protected $messages = [
        'csvFile.required' => 'El archivo CSV es requerido.',
        'csvFile.mimes' => 'El archivo debe ser de tipo CSV o texto.',
        'csvFile.max' => 'El archivo no debe pesar más de 10MB.',
        'sourceName.required' => 'La fuente es requerida.',
        'sourceName.min' => 'La fuente debe tener al menos 3 caracteres.',
        'sourceTypeId.required' => 'El tipo de fuente es requerido.',
        'sourceTypeId.exists' => 'El tipo de fuente seleccionado no es válido.',
    ];

    public function mount()
    {
        // Set default source type if any exists
        $defaultType = SourceType::where('name', 'Libro')->first();
        if ($defaultType) {
            $this->sourceTypeId = $defaultType->id;
        }
    }

    public function updatedSourceName()
    {
        $query = trim($this->sourceName);
        if ($query === '') {
            $this->sources = Source::whereHas('quotes')
                ->withMax('quotes as last_used', 'updated_at')
                ->orderBy('last_used', 'desc')
                ->limit(5)
                ->pluck('name')
                ->toArray();
        } else {
            $this->sources = Source::where('name', 'like', '%' . $query . '%')
                ->select('name')
                ->distinct()
                ->limit(5)
                ->pluck('name')
                ->toArray();
        }
    }

    public function selectSource($name)
    {
        $this->sourceName = $name;
        $this->sources = [];

        // If this source exists, auto-select its source type
        $existingSource = Source::where('name', $name)->first();
        if ($existingSource) {
            $this->sourceTypeId = $existingSource->source_type_id;
        }
    }

    public function loadRecentSources()
    {
        if (empty($this->sourceName)) {
            $this->sources = Source::whereHas('quotes')
                ->withMax('quotes as last_used', 'updated_at')
                ->orderBy('last_used', 'desc')
                ->limit(5)
                ->pluck('name')
                ->toArray();
        }
    }

    protected function detectDelimiter(string $filePath): string
    {
        $file = fopen($filePath, 'r');
        if ($file) {
            $firstLine = fgets($file);
            fclose($file);

            $commas = substr_count($firstLine, ',');
            $semicolons = substr_count($firstLine, ';');

            return $semicolons > $commas ? ';' : ',';
        }
        return ',';
    }

    public function import()
    {
        $this->validate();

        $tempPath = $this->csvFile->getRealPath();
        $delimiter = $this->detectDelimiter($tempPath);

        $this->successCount = 0;
        $this->skippedQuotes = [];
        $this->errorMessage = '';
        $this->isImported = false;

        try {
            DB::beginTransaction();

            $source = Source::firstOrCreate([
                'name' => trim($this->sourceName),
                'source_type_id' => $this->sourceTypeId
            ]);

            $reader = SimpleExcelReader::create($tempPath, 'csv')
                ->useDelimiter($delimiter);

            $rows = $reader->getRows();
            $lineIndex = 1; // Line 1 is the header row
            $processedRows = [];

            foreach ($rows as $row) {
                $lineIndex++;

                $quoteText = null;
                $bibleVerse = null;

                // Handle header names flexibly (lowercase/trimmed)
                foreach ($row as $key => $value) {
                    $normKey = strtolower(trim($key));
                    if ($normKey === 'quote' || $normKey === 'frase') {
                        $quoteText = $value;
                    } elseif ($normKey === 'bible_verse' || $normKey === 'referencia_biblica' || $normKey === 'referencia bíblica' || $normKey === 'referencia') {
                        $bibleVerse = $value;
                    }
                }

                // Validation: If phrase is empty, throw error to rollback transaction (Option A)
                if (is_null($quoteText) || trim($quoteText) === '') {
                    throw new \Exception("Error en la línea {$lineIndex}: La frase (columna 'quote') no puede estar vacía.");
                }

                $processedRows[] = [
                    'line' => $lineIndex,
                    'quote' => trim($quoteText),
                    'bible_verse' => $bibleVerse ? trim($bibleVerse) : null,
                ];
            }

            if (empty($processedRows)) {
                throw new \Exception("El archivo CSV no contiene ninguna fila de datos.");
            }

            // Now perform insertions
            foreach ($processedRows as $item) {
                // Check if quote already exists under the same source
                $existing = Quote::withoutGlobalScope('active')
                    ->where('quote', $item['quote'])
                    ->where('source_id', $source->id)
                    ->first();

                if ($existing) {
                    // Option A: Skip duplicates and record details
                    $this->skippedQuotes[] = [
                        'line' => $item['line'],
                        'quote' => $item['quote'],
                        'bible_verse' => $item['bible_verse']
                    ];
                    continue;
                }

                Quote::create([
                    'quote' => $item['quote'],
                    'bible_verse' => $item['bible_verse'],
                    'source_id' => $source->id,
                    'status' => true,
                ]);

                $this->successCount++;
            }

            DB::commit();
            $this->isImported = true;
            $this->csvFile = null; // Clear file input after success

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        $source_types = SourceType::all();

        return view('livewire.quotes-import', [
            'source_types' => $source_types
        ])->layout('layouts.app', [
            'header' => __('Importar Frases')
        ]);
    }
}
