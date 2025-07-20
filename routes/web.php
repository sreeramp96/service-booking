<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('services', ServiceController::class);

    Route::resource('services.availabilities', AvailabilityController::class)->except(['show']);

    Route::get('/services/{service}/slots', [BookingController::class, 'showSlots'])->name('services.slots');

    Route::post('/services/{service}/book/{availability}', [BookingController::class, 'book'])->name('services.book');

    Route::get('/provider/dashboard', function () {
        $services = auth()->user()->services;
        return view('dashboards.provider', compact('services'));
    })->name('provider.dashboard');

    Route::get('/customer/dashboard', function () {
        $bookings = auth()->user()->bookings()->with('service', 'availability')->latest()->take(5)->get();
        return view('dashboards.customer', compact('bookings'));
    })->name('customer.dashboard');
});

require __DIR__ . '/auth.php';
