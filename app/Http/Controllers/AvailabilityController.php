<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }

        $availabilities = $service->availabilities()->orderBy('date')->get();
        return view('availabilities.index', compact('service', 'availabilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }

        return view('availabilities.create', compact('service'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $service->availabilities()->create($data);

        return redirect()->route('services.availabilities.index', $service)->with('success', 'Slot added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
