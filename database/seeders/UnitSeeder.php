<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Location;
use App\Models\UnitType;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $location = Location::where('type', 'city')->firstOrFail();
        $types = UnitType::pluck('id', 'name');

        $ministry = Unit::create(['name' => 'وزارت بهداشت', 'type_id' => $types['ministry'], 'slug' => 'ministry-of-health']);

        Unit::create(['name' => 'دانشگاه علوم پزشکی تهران', 'type_id' => $types['university'], 'parent_id' => $ministry->id, 'location_id' => $location->id, 'slug' => 'tehran-university']);

        $deputy = Unit::create(['name' => 'معاونت بهداشت', 'type_id' => $types['deputy'], 'parent_id' => $ministry->id, 'location_id' => $location->id, 'slug' => 'health-deputy']);

        $network = Unit::create(['name' => 'شبکه بهداشت و درمان تهران', 'type_id' => $types['network'], 'parent_id' => $deputy->id, 'location_id' => $location->id, 'slug' => 'tehran-network']);

        $center = Unit::create(['name' => 'مرکز بهداشت تهران', 'type_id' => $types['center_health'], 'parent_id' => $network->id, 'location_id' => $location->id, 'slug' => 'tehran-center']);

        Unit::create(['name' => 'بیمارستان نمونه', 'type_id' => $types['hospital'], 'parent_id' => $network->id, 'location_id' => $location->id, 'slug' => 'sample-hospital']);

        Unit::create(['name' => 'مرکز جامع سلامت شهری', 'type_id' => $types['health_center'], 'parent_id' => $center->id, 'location_id' => $location->id, 'slug' => 'urban-health-center']);

        Unit::create(['name' => 'خانه بهداشت نمونه', 'type_id' => $types['health_house'], 'parent_id' => $center->id, 'location_id' => $location->id, 'slug' => 'sample-health-house']);
    }
}