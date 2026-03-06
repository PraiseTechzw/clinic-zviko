@extends('layouts.app')

@section('title', 'Schedule Appointment')

@section('content')
    <h2 class="fw-bold mb-4">Book New Appointment</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/appointments" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Patient</label>
                            <select name="patient_id" class="form-select" required>
                                <option value="">-- Choose Patient --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->full_name }} ({{ $patient->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Doctor</label>
                            <select name="doctor_id" class="form-select" required>
                                <option value="">-- Choose Doctor --</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->user->name }}
                                        ({{ $doctor->specialization }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Appointment Date & Time</label>
                            <input type="datetime-local" name="appointment_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason for Visit / Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">Book Appointment</button>
                            <a href="/appointments" class="btn btn-link">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection