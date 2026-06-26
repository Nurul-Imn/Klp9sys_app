<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPets = Pet::count();
        $totalServices = Service::count();
        $totalProducts = Product::count();
        $totalBookings = Booking::count();
        
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');
        
        $recentBookings = Booking::with(['user', 'pet', 'service'])
            ->latest()
            ->take(5)
            ->get();
            
        $recentPets = Pet::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPets',
            'totalServices',
            'totalProducts',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'totalRevenue',
            'recentBookings',
            'recentPets'
        ));
    }
}