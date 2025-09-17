<?php

   namespace Database\Seeders;

   use Illuminate\Database\Seeder;
   use App\Models\User;
   use Illuminate\Support\Facades\Hash;

   class UserSeeder extends Seeder
   {
       public function run(): void
       {
           User::create([
               'national_id' => '1234567890',
               'name' => 'Super Admin',
               'email' => 'admin@example.com',
               'password' => Hash::make('password123'),
           ]);
       }
   }