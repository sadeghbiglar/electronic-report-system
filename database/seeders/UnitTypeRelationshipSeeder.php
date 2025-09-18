<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitTypeRelationship;
use App\Models\UnitType;

class UnitTypeRelationshipSeeder extends Seeder
{
    public function run(): void
    {
        $types = UnitType::pluck('id', 'name');

        // روابط نمونه: ministry می‌تونه parent university باشه
        UnitTypeRelationship::create(['parent_type_id' => $types['ministry'], 'child_type_id' => $types['university']]);
        // university parent deputy
        UnitTypeRelationship::create(['parent_type_id' => $types['university'], 'child_type_id' => $types['deputy']]);
        // deputy parent network
        UnitTypeRelationship::create(['parent_type_id' => $types['deputy'], 'child_type_id' => $types['network']]);
        // network parent center_health, hospital, emergency_base
        UnitTypeRelationship::create(['parent_type_id' => $types['network'], 'child_type_id' => $types['center_health']]);
        UnitTypeRelationship::create(['parent_type_id' => $types['network'], 'child_type_id' => $types['hospital']]);
        UnitTypeRelationship::create(['parent_type_id' => $types['network'], 'child_type_id' => $types['emergency_base']]);
        // center_health parent health_center, health_house, health_base
        UnitTypeRelationship::create(['parent_type_id' => $types['center_health'], 'child_type_id' => $types['health_center']]);
        UnitTypeRelationship::create(['parent_type_id' => $types['center_health'], 'child_type_id' => $types['health_house']]);
        UnitTypeRelationship::create(['parent_type_id' => $types['center_health'], 'child_type_id' => $types['health_base']]);
        // اضافه کردن روابط بیشتر بر اساس نیاز (مثل مرکز روستایی برای خانه بهداشت)
    }
}