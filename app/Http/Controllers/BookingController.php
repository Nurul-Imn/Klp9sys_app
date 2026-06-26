<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('bookings.index');
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return view('bookings.show');
    }

    public function edit(string $id)
    {
        return view('bookings.edit');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}