<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitType;

class UnitTypeSeeder extends Seeder
{
    public function run(): void
    {
        UnitType::create(['name' => 'ministry', 'label' => 'وزارت']);
        UnitType::create(['name' => 'university', 'label' => 'دانشگاه']);
        UnitType::create(['name' => 'deputy', 'label' => 'معاونت']);
        UnitType::create(['name' => 'network', 'label' => 'شبکه']);
        UnitType::create(['name' => 'center_health', 'label' => 'مرکز بهداشت']);
        UnitType::create(['name' => 'hospital', 'label' => 'بیمارستان']);
        UnitType::create(['name' => 'emergency_base', 'label' => 'پایگاه فوریت']);
        UnitType::create(['name' => 'health_center', 'label' => 'مرکز جامع سلامت']);
        UnitType::create(['name' => 'health_house', 'label' => 'خانه بهداشت']);
        UnitType::create(['name' => 'health_base', 'label' => 'پایگاه سلامت']);
    }
}