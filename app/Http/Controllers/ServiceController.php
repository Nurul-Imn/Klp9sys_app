<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $services = Service::all();

    return response()->json($services);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'service_name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'duration' => 'required|integer',
    ]);

    $service = Service::create([
        'service_name' => $request->service_name,
        'description' => $request->description,
        'price' => $request->price,
        'duration' => $request->duration,
    ]);

    return response()->json([
        'message' => 'Service berhasil ditambahkan',
        'data' => $service
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $service = Service::findOrFail($id);

    return response()->json($service);
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
    $service = Service::findOrFail($id);

    $service->update([
        'service_name' => $request->service_name,
        'description' => $request->description,
        'price' => $request->price,
        'duration' => $request->duration,
    ]);

    return response()->json([
        'message' => 'Service berhasil diupdate'
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $service = Service::findOrFail($id);

    $service->delete();

    return response()->json([
        'message' => 'Service berhasil dihapus'
    ]);
    }
}
