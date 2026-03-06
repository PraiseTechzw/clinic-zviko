@extends('layouts.app')

@section('title', 'Consultation')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Patient Information</div>
                <div class="card-body">
                    <h5 class="fw-bold">{{ $patient->full_name }}</h5>
                    <p class="mb-1"><strong>Gender:</strong> {{ $patient->gender }}</p>
                    <p class="mb-1"><strong>Age:</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</p>
                    <hr>
                    <h6>Medical History</h6>
                    <div class="mt-3">
                        @forelse($patient->medicalRecords as $record)
                            <div class="mb-3 p-2 bg-light rounded border-start border-4 border-info">
                                <small class="text-muted">{{ $record->visit_date->format('M d, Y') }} - Dr.
                                    {{ $record->doctor->user->name }}</small>
                                <div class="fw-bold mt-1 text-primary">{{ $record->diagnosis }}</div>
                                <div class="small">{{ $record->treatment }}</div>
                            </div>
                        @empty
                            <p class="text-muted small">No previous records.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">New Consultation Notes</div>
                <div class="card-body">
                    <form action="/doctor/medical-records" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="visit_date" value="{{ date('Y-m-d') }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnosis</label>
                            <textarea name="diagnosis" class="form-control" rows="3"
                                placeholder="Enter patient diagnosis..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Treatment / Prescription</label>
                            <textarea name="treatment" class="form-control" rows="5"
                                placeholder="Enter treatment plan or prescriptions..." required></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success px-5">Save and Complete Consultation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection