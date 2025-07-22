<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    // If user is already authenticated, redirect to their dashboard
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->role === 'provider') {
            return redirect()->route('provider.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }
    }

    // If not authenticated, show the landing page
    return view('index');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'provider') {
            return redirect()->route('provider.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        // Fallback if role is not set properly
        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('services', ServiceController::class);
    Route::resource('services.availabilities', AvailabilityController::class)->except(['show']);

    Route::get('/services/{service}/slots', [BookingController::class, 'showSlots'])->name('services.slots');
    Route::post('/services/{service}/book/{availability}', [BookingController::class, 'book'])->name('services.book');

    Route::get('/provider/dashboard', function () {
        $services = auth()->user()->services()->with(['bookings', 'reviews'])->get();
        $totalBookings = auth()->user()->services()->withCount('bookings')->get()->sum('bookings_count');
        $totalRevenue = $totalBookings * 1000; // Rough calculation - you can make this more accurate
        $pendingBookings = \App\Models\Booking::whereHas('service', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'pending')->count();

        return view('dashboards.provider', compact('services', 'totalBookings', 'totalRevenue', 'pendingBookings'));
    })->name('provider.dashboard');

    Route::get('/customer/dashboard', function () {
        $user = auth()->user();

        // Get all bookings with related data
        $bookings = $user->bookings()
            ->with(['service.user', 'availability', 'service.reviews'])
            ->latest()
            ->get();

        // Get recent bookings for the main display (limit to 5)
        $recentBookings = $bookings->take(5);

        // Calculate additional stats
        $totalBookings = $bookings->count();
        $confirmedBookings = $bookings->where('status', 'confirmed')->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();

        // Get upcoming bookings (today and future)
        $upcomingBookings = $bookings->filter(function ($booking) {
            return \Carbon\Carbon::parse($booking->availability->date)->isToday() ||
                \Carbon\Carbon::parse($booking->availability->date)->isFuture();
        });

        // Get user's favorite services for recommendations
        $favoriteServices = $user->favoriteServices()
            ->with(['user', 'reviews'])
            ->limit(3)
            ->get();

        // Get recommended services based on booking history
        $recommendedServices = collect();
        if ($bookings->isNotEmpty()) {
            $bookedServiceIds = $bookings->pluck('service_id')->unique();
            $recommendedServices = \App\Models\Service::whereNotIn('id', $bookedServiceIds)
                ->with(['user', 'reviews'])
                ->withAvg('reviews', 'rating')
                ->withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->limit(3)
                ->get();
        }

        // Get unread messages count
        $unreadMessagesCount = $user->getUnreadMessagesCount();

        return view('dashboards.customer', compact(
            'bookings',
            'recentBookings',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'upcomingBookings',
            'favoriteServices',
            'recommendedServices',
            'unreadMessagesCount'
        ));
    })->name('customer.dashboard');


    // Review routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/bookings/{booking}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/services/{service}/reviews', [ReviewController::class, 'show'])->name('reviews.show');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Favorite routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/services/{service}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/services/{service}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/services/{service}/toggle-favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Message routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/start/{service}', [MessageController::class, 'startConversation'])->name('messages.start');

    // Rebooking route
    Route::post('/bookings/{booking}/rebook', [BookingController::class, 'rebook'])->name('bookings.rebook');
});

require __DIR__ . '/auth.php';
