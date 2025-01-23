<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\SourceType;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quote = Quote::inRandomOrder()->first();
        $words = explode(' ', $quote->quote);

        return view('quotes.index', compact('quote', 'words'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $source_types = SourceType::all();

        return view('quotes.create', compact('source_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'quote' => 'string|required',
            'bible_verse' => 'string|nullable',
            'source_type_id' => 'nullable|exists:source_types,id',
            'source' => 'string|nullable',
        ]);

        Quote::create($validate);

        return redirect()->route('quotes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
