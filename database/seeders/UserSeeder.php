<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Receptionist
        User::create([
            'name' => 'Reception User',
            'email' => 'reception@clinic.com',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
        ]);

        // Doctor
        $doctorUser = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@clinic.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'specialization' => 'General Physician',
        ]);
    }
}
