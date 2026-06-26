<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Service::create([
        'service_name' => 'Grooming',
        'description' => 'Layanan mandi dan perawatan bulu',
        'price' => 50000,
        'duration' => 60,
        ]);
       
        Service::create([
        'service_name' => 'Vaksin',
        'description' => 'Layanan vaksinasi hewan',
        'price' => 100000,
        'duration' => 30,
        ]);

        Service::create([
        'service_name' => 'Pemeriksaan',
        'description' => 'Pemeriksaan kesehatan hewan',
        'price' => 75000,
        'duration' => 45,
        ]);
        
    Service::create([
        'service_name' => 'Pet Hotel',
        'description' => 'Penitipan hewan peliharaan',
        'price' => 150000,
        'duration' => 1440,
        ]);
    }
}
