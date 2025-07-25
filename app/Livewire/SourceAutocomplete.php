<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Source;

class SourceAutocomplete extends Component
{
    public $query = '';
    public $sources = [];

    public function mount($curSource)
    {
        $this->query = $curSource;
    }

    public function updatedQuery()
    {
        if (trim($this->query) === '') {
            $this->loadRecentSources();
        } else {
            $this->sources = Source::where('name', 'like', '%' . $this->query . '%')
                ->select('name')
                ->distinct()
                ->limit(3)
                ->pluck('name')
                ->toArray();
        }
    }

    public function loadRecentSources()
    {
        $this->sources = Source::whereHas('quotes')
            ->withMax('quotes as last_used', 'updated_at')
            ->orderBy('last_used', 'desc')
            ->limit(3)
            ->pluck('name')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.source-autocomplete');
    }
}
