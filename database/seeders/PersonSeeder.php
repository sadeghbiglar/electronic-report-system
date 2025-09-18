<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Unit;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::first();

        Person::create([
            'national_id' => '1234567890',
            'name' => 'ادمین سیستم',
            'phone' => '09123456789',
            'unit_id' => $unit->id,
        ]);

        Person::create([
            'national_id' => '0987654321',
            'name' => 'کاربر تست',
            'phone' => '09198765432',
            'unit_id' => $unit->id,
        ]);
    }
}