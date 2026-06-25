<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
    $pets = Pet::all();

    return response()->json($pets);
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
        'user_id' => 'required',
        'name' => 'required',
        'species' => 'required',
        'breed' => 'required',
        'age' => 'required',
        'weight' => 'required'
    ]);

    $pet = Pet::create($request->all());

    return response()->json([
        'message' => 'Pet berhasil ditambahkan',
        'data' => $pet
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = Pet::findOrFail($id);

        return response()->json($pet);
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
    $pet = Pet::findOrFail($id);

    $pet->update($request->all());

    return response()->json([
        'message' => 'Data berhasil diupdate',
        'data' => $pet
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $pet = Pet::findOrFail($id);

    $pet->delete();

    return response()->json([
        'message' => 'Data berhasil dihapus'
    ]);
    }
}
