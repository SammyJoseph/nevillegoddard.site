<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;

class QuoteDisplay extends Component
{
    public $words;
    public $quote;
    public $shownQuotes = [];
    public $currentIndex = -1;

    public function mount()
    {
        $this->refreshQuote();
    }

    public function loadQuoteById($id)
    {
        $newQuote = Quote::with('source.sourceType')->find($id);
        if ($newQuote) {
            $this->quote = $newQuote;
            $this->words = explode(' ', $this->quote->quote);
            $this->dispatch('quote-refreshed');
        }
    }

    public function previousQuote()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->loadQuoteById($this->shownQuotes[$this->currentIndex]);
        }
    }

    public function nextQuote()
    {
        if ($this->currentIndex < count($this->shownQuotes) - 1) {
            $this->currentIndex++;
            $this->loadQuoteById($this->shownQuotes[$this->currentIndex]);
        } else {
            $this->refreshQuote();
        }
    }

    public function refreshQuote()
    {
        $newQuote = Quote::with('source.sourceType')
            ->whereNotIn('id', $this->shownQuotes)
            ->inRandomOrder()
            ->first();
    
        if (!$newQuote) {
            $this->shownQuotes = [];
            $this->currentIndex = -1;
            $newQuote = Quote::with('source.sourceType')
                ->inRandomOrder()
                ->first();
        }
    
        if ($newQuote) {
            $this->shownQuotes[] = $newQuote->id;
            $this->currentIndex = count($this->shownQuotes) - 1;
            $this->quote = $newQuote;
            $this->words = explode(' ', $this->quote->quote);
            $this->dispatch('quote-refreshed');
        } else {
            $this->words = [];
        }
    }
    
    public function render()
    {
        return view('livewire.quote-display');
    }
}
