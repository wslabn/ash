<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Customers\Index as CustomersIndex;
use App\Livewire\Customers\Create as CustomersCreate;
use App\Livewire\Customers\Edit as CustomersEdit;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Products\Create as ProductsCreate;
use App\Livewire\Products\Edit as ProductsEdit;
use App\Livewire\Sales\Index as SalesIndex;
use App\Livewire\Sales\Create as SalesCreate;
use App\Livewire\Sales\Show as SalesShow;

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
    
    Route::get('/products', ProductsIndex::class)->name('products.index');
    Route::get('/products/create', ProductsCreate::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductsEdit::class)->name('products.edit');
    
    Route::get('/sales', SalesIndex::class)->name('sales.index');
    Route::get('/sales/create', SalesCreate::class)->name('sales.create');
    Route::get('/sales/{id}', SalesShow::class)->name('sales.show');
});

require __DIR__.'/auth.php';
