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

    /**
     * Streams the mobile companion app APK with proper headers.
     */
    public function downloadApk()
    {
        $path = public_path('downloads/cctn-app.apk');
        
        if (!file_exists($path)) {
            abort(404, 'The requested APK file could not be found.');
        }

        return response()->download($path, 'cctn-app.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
