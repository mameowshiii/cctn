<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->where('price', '>', 0)->orderBy('price', 'asc')->get();

        // Get troubleshooting service ID dynamically
        $troubleService = Service::where('service_name', 'like', '%Troubleshooting%')->first();
        $troubleId = $troubleService ? $troubleService->id : 16;

        return view('home', compact('services', 'troubleId'));
    }
}
