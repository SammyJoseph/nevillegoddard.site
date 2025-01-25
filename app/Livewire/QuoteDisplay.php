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
        $newQuote = Quote::whereNotIn('id', $this->shownQuotes)
            ->inRandomOrder()
            ->first();
    
        if (!$newQuote) { // if all quotes have been shown, reset shownQuotes
            $this->shownQuotes = [];
            $newQuote = Quote::inRandomOrder()->first();
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
