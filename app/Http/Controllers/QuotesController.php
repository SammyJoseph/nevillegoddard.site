<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Source;
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
        $quotes = Quote::withoutGlobalScope('active')->orderBy('created_at', 'desc')->paginate(10);

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
            'quote'             => 'string|required',
            'bible_verse'       => 'string|nullable',
            'source_type_id'    => 'exists:source_types,id|required',
            'source'            => 'string|min:3|required',
        ]);
        $status = $request->input('status', '0') == '1' ? 1 : 0;
        $validated['status'] = $status; // agregar el campo 'status' al array validado

        $source = Source::firstOrCreate(
            [
                'name' => $validated['source'],
                'source_type_id' => $validated['source_type_id']
            ]
        );
        $validated['source_id'] = $source->id;

        $validated['quote'] = trim($validated['quote']); // quitar espacios en blanco

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
    public function edit($id)
    {
        $quote = Quote::withoutGlobalScope('active')->findOrFail($id);
        $source_types = SourceType::all();
    
        return view('quotes.edit', compact('quote', 'source_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'quote'             => 'string|required',
            'bible_verse'       => 'string|nullable',
            'source_type_id'    => 'exists:source_types,id|required',
            'source'            => 'string|min:3|required',
        ]);
        
        $status = $request->input('status', '0') == '1' ? 1 : 0;
        $validated['status'] = $status;
    
        $source = Source::firstOrCreate(
            [
                'name' => $validated['source'],
                'source_type_id' => $validated['source_type_id']
            ]
        );
        $validated['source_id'] = $source->id;
    
        $validated['quote'] = trim($validated['quote']);
    
        $quote->update($validated);
    
        return redirect()->route('quotes.index')->with('success', $quote->quote.' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
