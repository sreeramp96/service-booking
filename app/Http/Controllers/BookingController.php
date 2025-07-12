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
}
