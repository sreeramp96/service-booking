<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = auth()->user()->reviews()
            ->with(['service', 'booking'])
            ->latest()
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function create(Booking $booking)
    {
        // Check if user can review this booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'You can only review confirmed bookings.');
        }

        if ($booking->review) {
            return redirect()->back()->with('error', 'You have already reviewed this booking.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'quality_rating' => 'nullable|integer|min:1|max:5',
            'punctuality_rating' => 'nullable|integer|min:1|max:5',
            'value_rating' => 'nullable|integer|min:1|max:5',
            'is_anonymous' => 'boolean'
        ]);

        // Check permissions
        if ($booking->user_id !== auth()->id() || $booking->status !== 'confirmed') {
            abort(403);
        }

        $ratingCategories = null;
        if ($request->filled(['quality_rating', 'punctuality_rating', 'value_rating'])) {
            $ratingCategories = [
                'quality' => $request->quality_rating,
                'punctuality' => $request->punctuality_rating,
                'value' => $request->value_rating
            ];
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'service_id' => $booking->service_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'rating_categories' => $ratingCategories,
            'is_anonymous' => $request->boolean('is_anonymous')
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Thank you for your review!');
    }

    public function show(Service $service)
    {
        $reviews = $service->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('reviews.show', compact('service', 'reviews'));
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
