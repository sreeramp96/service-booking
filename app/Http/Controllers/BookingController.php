<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Availability;
use App\Models\Booking;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function showSlots(Service $service)
    {
        $slots = $service->availabilities()->whereDoesntHave('bookings')->orderBy('date')->get();
        return view('bookings.slots', compact('service', 'slots'));
    }

    public function book(Service $service, Availability $availability)
    {
        // Prevent double booking
        if ($availability->bookings()->exists()) {
            return back()->with('error', 'Slot already booked.');
        }

        Booking::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'availability_id' => $availability->id,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking successful!');
    }
    public function rebook(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Redirect to the service's slots page for rebooking
        return redirect()->route('services.slots', $booking->service)
            ->with('success', 'Choose a new slot for rebooking ' . $booking->service->name);
    }

    // Also add this helper method to show booking history
    public function history()
    {
        $bookings = auth()->user()->bookings()
            ->with(['service.user', 'availability', 'review'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }
}
