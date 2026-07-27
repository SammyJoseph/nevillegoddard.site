<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Component;

class QuoteDisplay extends Component
{
    public function render()
    {
        $user = auth()->user();
        $isAdmin = $user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['admin', 'super-admin']);

        $quotes = Quote::with('source.sourceType')
            ->get()
            ->shuffle()
            ->map(function ($quote) use ($isAdmin) {
                $sourceType = optional(optional($quote->source)->sourceType)->name;
                $sourceName = optional($quote->source)->name;
                $sourceText = ($sourceType && $sourceName) ? "{$sourceType}: {$sourceName}" : ($sourceName ?: '');

                return [
                    'id' => $quote->id,
                    'quote' => $quote->quote,
                    'words' => array_values(array_filter(explode(' ', $quote->quote), fn($w) => $w !== '')),
                    'bible_verse' => $quote->bible_verse,
                    'source_text' => $sourceText,
                    'edit_url' => $isAdmin ? route('quotes.edit', $quote) : null,
                ];
            })
            ->values()
            ->toArray();

        return view('livewire.quote-display', compact('quotes'));
    }
}

