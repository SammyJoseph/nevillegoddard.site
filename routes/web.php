<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuotesController::class, 'index'])->name('quotes.index');
Route::resource('quotes', QuotesController::class)->except(['index'])->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
