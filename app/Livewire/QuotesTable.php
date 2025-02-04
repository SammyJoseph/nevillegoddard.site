<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;

class QuotesTable extends Component
{
    public function render()
    {
        $quotes = Quote::withoutGlobalScope('active')->orderBy('created_at', 'desc')->get();

        return view('livewire.quotes-table', compact('quotes'));
    }
}
