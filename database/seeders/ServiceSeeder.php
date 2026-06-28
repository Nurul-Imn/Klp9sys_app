<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name'             => 'Grooming Basic',
                'category'         => 'Grooming',
                'description'      => 'Layanan mandi dan perawatan bulu dasar',
                'price'            => 50000,
                'duration_minutes' => 60,
                'is_active'        => true,
            ],
            [
                'name'             => 'Vaksinasi',
                'category'         => 'Medical',
                'description'      => 'Layanan vaksinasi hewan peliharaan',
                'price'            => 100000,
                'duration_minutes' => 30,
                'is_active'        => true,
            ],
            [
                'name'             => 'Pemeriksaan Kesehatan',
                'category'         => 'Medical',
                'description'      => 'Pemeriksaan kesehatan umum oleh dokter hewan',
                'price'            => 75000,
                'duration_minutes' => 45,
                'is_active'        => true,
            ],
            [
                'name'             => 'Pet Hotel',
                'category'         => 'Boarding',
                'description'      => 'Penitipan hewan peliharaan per malam',
                'price'            => 150000,
                'duration_minutes' => 1440,
                'is_active'        => true,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }
    }
}