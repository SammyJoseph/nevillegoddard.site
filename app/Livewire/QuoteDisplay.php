<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;

class QuoteDisplay extends Component
{
    public $words;
    public $quote;
    public $shownQuotes = [];

    public function mount()
    {
        $this->refreshQuote();
    }

    public function refreshQuote()
    {
        $newQuote = Quote::with('source.sourceType')
            ->whereNotIn('id', $this->shownQuotes)
            ->where('status', true)
            ->inRandomOrder()
            ->first();
    
        if (!$newQuote) {
            $this->shownQuotes = [];
            $newQuote = Quote::with('source.sourceType')
                ->where('status', true)
                ->inRandomOrder()
                ->first();
        }
    
        $this->quote = $newQuote;
        $this->shownQuotes[] = $this->quote->id;
        $this->words = explode(' ', $this->quote->quote);
        $this->dispatch('quote-refreshed');
    }
    
    public function render()
    {
        return view('livewire.quote-display');
    }
}
