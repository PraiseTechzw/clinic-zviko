<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'appointments_today' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'active_doctors' => Doctor::count(),
            'total_records' => MedicalRecord::count(),
        ];

        $recent_appointments = Appointment::with(['patient', 'doctor.user'])
            ->latest()
            ->take(5)
            ->get();

        $doctors = Doctor::with('user')
            ->withCount([
                'appointments' => function ($query) {
                    $query->whereDate('appointment_date', '>=', Carbon::today());
                }
            ])
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_appointments', 'doctors'));
    }

    public function staff()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.staff', compact('doctors'));
    }
}
