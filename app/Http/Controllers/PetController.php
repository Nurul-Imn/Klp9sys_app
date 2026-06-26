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
    return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:100',
        'species' => 'required|string|max:50',
        'breed' => 'required|string|max:50',
        'age' => 'required|integer|min:0|max:50',
        'weight' => 'required|numeric|min:0',
    ], [
        'name.required' => 'Nama hewan wajib diisi',
        'species.required' => 'Jenis hewan wajib diisi',
        'breed.required' => 'Ras hewan wajib diisi',
        'age.required' => 'Umur wajib diisi',
        'age.integer' => 'Umur harus berupa angka',
        'weight.numeric' => 'Berat harus berupa angka',
    ]);

    Pet::create([
        'user_id' => auth()->id(),
        'name' => $request->name,
        'species' => $request->species,
        'breed' => $request->breed,
        'age' => $request->age,
        'weight' => $request->weight,
    ]);

    return redirect()
            ->route('pets.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
   public function show(string $id)
    {
    $pet = Pet::findOrFail($id);

    return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $pet = Pet::findOrFail($id);

    return view('pets.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'name' => 'required|string|max:100',
        'species' => 'required|string|max:50',
        'breed' => 'required|string|max:50',
        'age' => 'required|integer|min:0|max:50',
        'weight' => 'required|numeric|min:0',
    ], [
        'name.required' => 'Nama hewan wajib diisi',
        'species.required' => 'Jenis hewan wajib diisi',
        'breed.required' => 'Ras hewan wajib diisi',
        'age.required' => 'Umur wajib diisi',
        'age.integer' => 'Umur harus berupa angka',
        'weight.numeric' => 'Berat harus berupa angka',
    ]);

    $pet = Pet::findOrFail($id);

    $pet->update([
        'name' => $request->name,
        'species' => $request->species,
        'breed' => $request->breed,
        'age' => $request->age,
        'weight' => $request->weight,
    ]);

    return redirect()
            ->route('pets.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
    $pet = Pet::findOrFail($id);

    $pet->delete();

    return redirect()
            ->route('pets.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
