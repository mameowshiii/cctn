<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::orderBy('id', 'desc')->get();

        $editService = null;
        if ($request->has('edit_id')) {
            $editService = Service::find($request->edit_id);
        }

        return view('admin.services.index', compact('services', 'editService'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name'     => 'required|string|max:100',
            'duration_minutes' => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
        ]);

        $id = $request->input('service_id', 0);

        $data = $request->only(['service_name', 'description', 'duration_minutes', 'price', 'status']);

        if ($id > 0) {
            $service = Service::findOrFail($id);
            $service->update($data);
            $msg = "Service '{$data['service_name']}' updated successfully.";
        } else {
            Service::create($data);
            $msg = "New service '{$data['service_name']}' created successfully.";
        }

        return redirect()->route('admin.services')->with('success_message', $msg);
    }

    public function destroy(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services')->with('success_message', 'Service deleted successfully.');
    }
}
