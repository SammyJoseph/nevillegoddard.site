<?php

namespace App\Livewire;

use App\Models\Quote;
use App\Models\Source;
use Livewire\Component;
use Livewire\WithPagination;

class QuotesTable extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedSource = '';

    public $perPage = 10;

    public $selectedQuotes = [];

    public $selectAll = false;

    public $confirmingQuotesDeletion = false;

    protected $queryString = ['search', 'selectedSource', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatingSelectedSource()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
        $this->resetSelection();
    }

    public function updatingPage()
    {
        $this->resetSelection();
    }

    private function resetSelection()
    {
        $this->selectedQuotes = [];
        $this->selectAll = false;
    }

    private function getQuotesQuery()
    {
        return Quote::withoutGlobalScope('active')
            ->with(['source.sourceType'])
            ->when($this->selectedSource, function ($query) {
                $query->where('source_id', $this->selectedSource);
            })
            ->where('quote', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc');
    }

    private function getCurrentPageQuoteIds()
    {
        $perPageVal = $this->perPage === 'all'
            ? max(1, $this->getQuotesQuery()->count())
            : (int)$this->perPage;

        return $this->getQuotesQuery()
            ->paginate($perPageVal)
            ->pluck('id')
            ->map(fn($id) => (string)$id)
            ->toArray();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedQuotes = $this->getCurrentPageQuoteIds();
        } else {
            $this->selectedQuotes = [];
        }
    }

    public function updatedSelectedQuotes()
    {
        $currentPageIds = $this->getCurrentPageQuoteIds();
        
        if (count($currentPageIds) > 0 && empty(array_diff($currentPageIds, $this->selectedQuotes))) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }

    public function confirmDeleteSelected()
    {
        $this->confirmingQuotesDeletion = true;
    }

    public function deleteSelected()
    {
        Quote::withoutGlobalScope('active')
            ->whereIn('id', $this->selectedQuotes)
            ->delete();

        $deletedCount = count($this->selectedQuotes);
        
        if ($this->selectedSource) {
            $hasQuotes = Quote::withoutGlobalScope('active')
                ->where('source_id', $this->selectedSource)
                ->exists();
            
            if (!$hasQuotes) {
                $this->selectedSource = '';
            }
        }

        $this->resetSelection();
        $this->resetPage();
        $this->confirmingQuotesDeletion = false;

        $this->dispatch('banner-message', 
            style: 'success', 
            message: $deletedCount === 1 
                ? 'La frase seleccionada ha sido eliminada correctamente.' 
                : "Las {$deletedCount} frases seleccionadas han sido eliminadas correctamente."
        );
    }

    public function render()
    {
        $perPageVal = $this->perPage === 'all'
            ? max(1, $this->getQuotesQuery()->count())
            : (int)$this->perPage;

        $quotes = $this->getQuotesQuery()->paginate($perPageVal);

        $sources = Source::withCount('quotes')->has('quotes')->orderBy('name')->get();

        $totalQuotesCount = Quote::withoutGlobalScope('active')->count();

        return view('livewire.quotes-table', compact('quotes', 'sources', 'totalQuotesCount'));
    }
}
