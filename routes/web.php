<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuotesController::class, 'home'])->name('quotes.home');
Route::resource('quotes', QuotesController::class)->middleware(['auth', 'role:super-admin']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
