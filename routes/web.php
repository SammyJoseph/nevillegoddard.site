<?php
 
use App\Http\Controllers\QuotesController;
use App\Livewire\QuotesImport;
use Illuminate\Support\Facades\Route;
 
Route::get('/', [QuotesController::class, 'home'])->name('quotes.home');

Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('quotes/import', QuotesImport::class)->name('quotes.import-form');
    Route::resource('quotes', QuotesController::class);
});
 
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
