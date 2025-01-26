<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\SourceType;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    public function home()
    {
        return view('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::orderBy('created_at', 'desc')->paginate(5);

        return view('quotes.index', compact('quotes'));
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
        $validated = $request->validate([
            'quote' => 'string|required',
            'bible_verse' => 'string|nullable',
            'source_type_id' => 'nullable|exists:source_types,id',
            'source' => 'string|nullable',
        ]);

        $validated['quote'] = trim($validated['quote']); // quitar espacios en blanco al principio y al final

        $quote = Quote::create($validated);

        return redirect()->route('quotes.index')->with('success', $quote->quote.' added successfully.');
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
