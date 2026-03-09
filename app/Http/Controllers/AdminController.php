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

        $urgent_alerts = Appointment::with(['patient', 'doctor.user'])
            ->whereIn('status', ['Scheduled', 'Rescheduled'])
            ->whereBetween('appointment_date', [Carbon::now(), Carbon::now()->addHour()])
            ->get();

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

        return view('admin.dashboard', compact('stats', 'recent_appointments', 'doctors', 'urgent_alerts'));
    }

    public function staff()
    {
        $users = \App\Models\User::with('doctor')->get();
        return view('admin.staff', compact('users'));
    }

    public function createStaff()
    {
        return view('admin.staff_create');
    }

    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,receptionist,doctor',
            'specialization' => 'required_if:role,doctor|nullable|string|max:255',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($validated['role'] === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $validated['specialization'] ?? 'General Physician',
            ]);
        }

        return redirect('/admin/staff')->with('success', 'Staff member added successfully.');
    }

    public function editStaff(\App\Models\User $user)
    {
        $user->load('doctor');
        return view('admin.staff_edit', compact('user'));
    }

    public function updateStaff(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,receptionist,doctor',
            'specialization' => 'required_if:role,doctor|nullable|string|max:255',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($validated['role'] === 'doctor') {
            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                ['specialization' => $validated['specialization']]
            );
        } else {
            Doctor::where('user_id', $user->id)->delete();
        }

        return redirect('/admin/staff')->with('success', 'Staff member updated.');
    }

    public function deleteStaff(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect('/admin/staff')->with('success', 'Staff member removed.');
    }

    public function reports()
    {
        $total_patients = Patient::count();
        $appointment_stats = Appointment::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $gender_dist = Patient::selectRaw('gender, count(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        $doctor_activity = Doctor::with('user')
            ->withCount('medicalRecords')
            ->get();

        return view('admin.reports', compact('total_patients', 'appointment_stats', 'doctor_activity', 'gender_dist'));
    }
}
