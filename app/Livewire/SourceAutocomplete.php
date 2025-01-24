<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quote;
class SourceAutocomplete extends Component
{
    public $query = '';
    public $sources = [];

    public function updatedQuery()
    {
        $this->sources = Quote::where('source', 'like', '%' . $this->query . '%')
            ->select('source')
            ->distinct()
            ->limit(3)
            ->pluck('source')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.source-autocomplete');
    }
}
