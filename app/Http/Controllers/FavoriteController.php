<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Service;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with(['service.user', 'service.reviews'])
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request, Service $service)
    {
        $user = auth()->user();

        // Check if already favorited
        if ($user->hasFavorited($service->id)) {
            return response()->json(['message' => 'Already in favorites'], 400);
        }

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'service_id' => $service->id
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Added to favorites',
                'favorited' => true
            ]);
        }

        return redirect()->back()->with('success', 'Service added to favorites!');
    }

    public function destroy(Service $service)
    {
        $user = auth()->user();

        $favorite = $user->favorites()->where('service_id', $service->id)->first();

        if (!$favorite) {
            return response()->json(['message' => 'Not in favorites'], 400);
        }

        $favorite->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'message' => 'Removed from favorites',
                'favorited' => false
            ]);
        }

        return redirect()->back()->with('success', 'Service removed from favorites!');
    }

    public function toggle(Service $service)
    {
        $user = auth()->user();

        $favorite = $user->favorites()->where('service_id', $service->id)->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
            $message = 'Removed from favorites';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'service_id' => $service->id
            ]);
            $favorited = true;
            $message = 'Added to favorites';
        }

        if (request()->expectsJson()) {
            return response()->json([
                'message' => $message,
                'favorited' => $favorited
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
