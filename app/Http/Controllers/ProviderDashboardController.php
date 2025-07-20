<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ProviderDashboardController extends Controller
{
    public function index()
    {
        $services = Service::where('user_id', auth()->id())->get();
        return view('dashboards.provider', compact('services'));
    }
}
