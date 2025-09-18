<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $province = Location::create(['name' => 'تهران', 'type' => 'province', 'slug' => 'tehran']);
        Location::create(['name' => 'شهرستان تهران', 'type' => 'city', 'parent_id' => $province->id, 'slug' => 'tehran-city']);
    }
}