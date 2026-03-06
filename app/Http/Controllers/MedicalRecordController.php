<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'visit_date' => 'required|date',
        ]);

        $doctor = Auth::user()->doctor;

        MedicalRecord::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctor->id,
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'visit_date' => $validated['visit_date'],
        ]);

        return redirect('/doctor/dashboard')->with('success', 'Consultation notes saved.');
    }
}
