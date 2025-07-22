<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CarManager;
use App\Livewire\GarageManager;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Rota do Dashboard Principal
    Route::get('/dashboard', CarManager::class)->name('dashboard');

    // Rota para Gerenciamento de Garagens
    Route::get('/garages', GarageManager::class)->name('garages.manager');

    // Grupo de Rotas do Admin
    Route::prefix('admin')->name('admin.')->middleware('role:super_admin')->group(function () {
        /*Route::get('/users', UserList::class)->name('users.index');*/
        /*Route::get('/rentals', RentalReport::class)->name('rentals.report');*/
    });
});
