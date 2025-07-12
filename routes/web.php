<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AvailabilityController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('services', ServiceController::class);

    Route::prefix('services/{service}')->group(function () {
        Route::resource('availabilities', AvailabilityController::class)->except(['show']);
    });

    Route::get('/services/{service}/slots', [BookingController::class, 'showSlots'])->name('services.slots');
    Route::post('/services/{service}/book/{availability}', [BookingController::class, 'book'])->name('services.book');

    Route::get('/provider/dashboard', function () {
        return view('dashboards.provider');
    })->name('provider.dashboard');

    Route::get('/customer/dashboard', function () {
        return view('dashboards.customer');
    })->name('customer.dashboard');
});

Route::middleware(['auth'])->get('/customer/dashboard', function () {
    $bookings = auth()->user()->bookings()->with('service', 'availability')->latest()->take(5)->get();

    return view('dashboards.customer', compact('bookings'));
})->name('customer.dashboard');

require __DIR__ . '/auth.php';
