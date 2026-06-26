<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Product;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Admin Pet Care',
            'email' => 'admin@petcare.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '089876543210',
        ]);

        // 2. Pets
        $pet1 = Pet::create([
            'user_id' => $customer->id,
            'name' => 'Milo',
            'species' => 'Kucing',
            'breed' => 'Persia',
            'gender' => 'Jantan',
            'age' => 2,
            'weight' => 4.20,
            'notes' => 'Sangat aktif dan manja. Alergi makanan laut.',
        ]);

        $pet2 = Pet::create([
            'user_id' => $customer->id,
            'name' => 'Bella',
            'species' => 'Anjing',
            'breed' => 'Golden Retriever',
            'gender' => 'Betina',
            'age' => 3,
            'weight' => 25.50,
            'notes' => 'Sangat ramah, suka bermain bola.',
        ]);

        // 3. Services
        $service1 = Service::create([
            'name' => 'Basic Grooming',
            'category' => 'Grooming',
            'price' => 75000,
            'duration_minutes' => 60,
            'description' => 'Mandi bersih, potong kuku, pembersihan telinga, dan sisir bulu.',
            'is_active' => true,
        ]);

        $service2 = Service::create([
            'name' => 'Premium Styling Grooming',
            'category' => 'Grooming',
            'price' => 150000,
            'duration_minutes' => 90,
            'description' => 'Grooming lengkap ditambah potong bulu stylish dan vitamin bulu.',
            'is_active' => true,
        ]);

        $service3 = Service::create([
            'name' => 'Konsultasi Dokter Hewan',
            'category' => 'Medical',
            'price' => 100000,
            'duration_minutes' => 30,
            'description' => 'Pemeriksaan kesehatan umum oleh dokter hewan profesional.',
            'is_active' => true,
        ]);

        $service4 = Service::create([
            'name' => 'Vaksinasi Rabies',
            'category' => 'Medical',
            'price' => 120000,
            'duration_minutes' => 15,
            'description' => 'Suntik vaksin rabies berkala untuk anjing atau kucing.',
            'is_active' => true,
        ]);

        // 4. Products
        Product::create([
            'name' => 'Royal Canin Mother & Babycat 400g',
            'category' => 'Makanan Kucing',
            'price' => 85000,
            'stock' => 25,
            'description' => 'Makanan kering khusus untuk anak kucing usia 1-4 bulan.',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Pedigree Dentastix Medium 112g',
            'category' => 'Makanan Anjing',
            'price' => 35000,
            'stock' => 50,
            'description' => 'Camilan pembersih karang gigi untuk anjing ras sedang.',
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Shampoo Kucing Anti-Kutu 250ml',
            'category' => 'Aksesoris & Perawatan',
            'price' => 45000,
            'stock' => 15,
            'description' => 'Shampoo khusus kucing formula pembasmi kutu dan jamur.',
            'is_active' => true,
        ]);

        // 5. Bookings & Payments
        $booking1 = Booking::create([
            'user_id' => $customer->id,
            'pet_id' => $pet1->id,
            'service_id' => $service1->id,
            'booking_code' => 'BK-' . strtoupper(Str::random(6)),
            'booking_date' => now()->addDays(1)->format('Y-m-d'),
            'time_slot' => '10:00 - 11:00',
            'status' => 'confirmed',
            'total_price' => $service1->price,
            'notes' => 'Tolong mandikan dengan shampoo anti-kutu.',
        ]);

        Payment::create([
            'booking_id' => $booking1->id,
            'transaction_id' => 'TX-' . strtoupper(Str::random(10)),
            'gateway' => 'Midtrans',
            'amount' => $booking1->total_price,
            'currency' => 'IDR',
            'payment_method' => 'E-Wallet (Gopay)',
            'status' => 'success',
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payload' => ['status_code' => '200', 'payment_type' => 'gopay'],
        ]);

        $booking2 = Booking::create([
            'user_id' => $customer->id,
            'pet_id' => $pet2->id,
            'service_id' => $service3->id,
            'booking_code' => 'BK-' . strtoupper(Str::random(6)),
            'booking_date' => now()->addDays(2)->format('Y-m-d'),
            'time_slot' => '14:00 - 14:30',
            'status' => 'pending',
            'total_price' => $service3->price,
            'notes' => 'Pemeriksaan rutin telinga gatal.',
        ]);

        Payment::create([
            'booking_id' => $booking2->id,
            'transaction_id' => null,
            'gateway' => 'Manual Transfer',
            'amount' => $booking2->total_price,
            'currency' => 'IDR',
            'payment_method' => 'Transfer BCA',
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'paid_at' => null,
            'payload' => null,
        ]);
    }
}
