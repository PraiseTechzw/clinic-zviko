<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->whereIn('status', ['Scheduled', 'Rescheduled'])
            ->orderBy('appointment_date')
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }

    public function consultation(Patient $patient)
    {
        $patient->load('medicalRecords.doctor.user');
        return view('doctor.consultation', compact('patient'));
    }
}
