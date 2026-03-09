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

    public function records(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor.user']);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhere('diagnosis', 'like', "%{$search}%")
                ->orWhere('treatment', 'like', "%{$search}%");
        }

        $records = $query->latest('visit_date')->paginate(15);
        return view('doctor.records', compact('records'));
    }
}
