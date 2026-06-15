<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('clientes', \App\Livewire\ClientManager::class)
    ->middleware(['auth', 'verified'])
    ->name('clients.index');

Route::get('pagos', \App\Livewire\PaymentManager::class)
    ->middleware(['auth', 'verified'])
    ->name('payments.index');

Route::get('productos', \App\Livewire\ProductManager::class)
    ->middleware(['auth', 'verified'])
    ->name('products.index');

Route::get('presupuestos', \App\Livewire\QuoteManager::class)
    ->middleware(['auth', 'verified'])
    ->name('quotes.index');

Route::get('usuarios', \App\Livewire\UserManager::class)
    ->middleware(['auth', 'verified'])
    ->name('users.index');

Route::get('soporte', \App\Livewire\ClientTicketPortal::class)
    ->name('soporte');

Route::get('tickets', \App\Livewire\TicketManager::class)
    ->middleware(['auth', 'verified'])
    ->name('tickets.index');

Route::get('reseller', \App\Livewire\ResellerManager::class)
    ->middleware(['auth', 'verified'])
    ->name('reseller.index');

Route::get('requerimientos', \App\Livewire\RequirementManager::class)
    ->middleware(['auth', 'verified'])
    ->name('requirements.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
