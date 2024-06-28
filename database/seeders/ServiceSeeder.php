<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'change the tires',
            'sold',
            'balance',
            'repair',
        ];
        foreach($services as $service){
            Service::create([
                'name'=> $service
            ]);
        }
    }
}
