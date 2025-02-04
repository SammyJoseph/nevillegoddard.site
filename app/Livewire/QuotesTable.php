<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;
use Livewire\WithPagination;

class QuotesTable extends Component
{
    use WithPagination;

    public $search = '';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $quotes = Quote::withoutGlobalScope('active')
            ->where('quote', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.quotes-table', compact('quotes'));
    }
}
