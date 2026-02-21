<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Customers\Create as CustomersCreate;
use App\Livewire\Customers\Edit as CustomersEdit;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customers', CustomersIndex::class)->name('customers.index');
    Route::get('/customers/create', CustomersCreate::class)->name('customers.create');
    Route::get('/customers/{id}/edit', CustomersEdit::class)->name('customers.edit');
});

require __DIR__.'/auth.php';
