<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Livewire\CategoriesTable;
use App\Livewire\ProductsTable;
use App\Livewire\HotelsTable;
// use App\Http\Controllers\HotelController;
use App\Livewire\ServicesTable;
use App\Livewire\RoomsTable;
use App\Livewire\RoomServicesManager;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::get('/categories');

    Route::middleware('auth')->group(function () {
        // ... otras rutas existentes

        Route::get('/categories', CategoriesTable::class)->name('categories.index');
        Route::get('/products', ProductsTable::class)->name('products.index');
    });

    // Hoteles
    Route::get('/hotels', HotelsTable::class)->name('hotels.index');
    Route::get('/hotels/create', [HotelsTable::class, 'create'])->name('hotels.create');
    Route::post('/hotels', [HotelsTable::class, 'store'])->name('hotels.store');

    // Servicios
    Route::middleware(['auth'])->group(function () {
        Route::get('/services', ServicesTable::class)->name('services.index');

        // Cuartos
        Route::get('/rooms', RoomsTable::class)->name('rooms.index');

        // Cuartos - Servicios
        Route::get('/roomservices', RoomServicesManager::class)->name('rooms.services');

    });
});

require __DIR__ . '/auth.php';
