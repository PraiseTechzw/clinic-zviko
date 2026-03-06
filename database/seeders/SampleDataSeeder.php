<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Patients
        $p1 = Patient::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'date_of_birth' => '1985-05-15',
            'phone' => '0712345678',
            'address' => '123 Main St, Central City',
        ]);

        $p2 = Patient::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'gender' => 'Female',
            'date_of_birth' => '1992-09-20',
            'phone' => '0788990011',
            'address' => '456 Oak Rd, Harbor View',
        ]);

        $doctor = Doctor::first();

        // 2. Create Appointments
        Appointment::create([
            'patient_id' => $p1->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => Carbon::tomorrow()->setHour(10)->setMinute(0),
            'status' => 'Scheduled',
            'notes' => 'Regular checkup.',
        ]);

        Appointment::create([
            'patient_id' => $p2->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => Carbon::today()->setHour(14)->setMinute(30),
            'status' => 'Scheduled',
            'notes' => 'Follow up on previous prescription.',
        ]);

        // 3. Create a Medical Record for history
        MedicalRecord::create([
            'patient_id' => $p1->id,
            'doctor_id' => $doctor->id,
            'visit_date' => Carbon::now()->subMonths(2),
            'diagnosis' => 'Mild Hypertension',
            'treatment' => 'Prescribed Amlodipine 5mg. Advised low salt diet.',
        ]);
    }
}
