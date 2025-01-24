<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;

class QuoteDisplay extends Component
{
    public $words;
    public $quote;

    public function mount()
    {
        $this->refreshQuote();
    }

    public function refreshQuote()
    {
        $this->quote = Quote::inRandomOrder()->first();
        $this->words = explode(' ', $this->quote->quote);
        $this->dispatch('quote-refreshed');
    }
    
    public function render()
    {
        return view('livewire.quote-display');
    }
}
