@extends('layouts.app')

@section('title', 'Consultation — ' . $patient->full_name)

@section('content')

    <style>
        .consult-layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 1.75rem;
            align-items: start;
        }

        @media (max-width: 991px) {
            .consult-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Patient panel */
        .patient-panel {
            position: sticky;
            top: 90px;
        }

        .patient-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0 auto 1.25rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.7rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            font-weight: 600;
        }

        .info-row .value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
        }

        /* History card */
        .history-entry {
            border-left: 3px solid #e2e8f0;
            padding-left: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .history-entry::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #6366f1;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #6366f1;
        }

        .history-entry.older::before {
            background: #94a3b8;
            box-shadow: 0 0 0 2px #94a3b8;
        }

        /* Form styling */
        .form-control,
        .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 0.85rem;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .save-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 1rem;
            padding: 0.85rem 2.5rem;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            transition: all 0.25s;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
            color: white;
        }

        .back-btn {
            color: #6366f1;
            background: rgba(99, 102, 241, 0.08);
            border: none;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .back-btn:hover {
            background: rgba(99, 102, 241, 0.15);
            color: #4f46e5;
        }

        .section-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border-radius: 0.65rem;
            padding: 0.35rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    {{-- Breadcrumb / Back --}}
    <div class="d-flex align-items-center gap-3 mb-4 animate__animated animate__fadeInDown">
        <a href="{{ url('/doctor/dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <span class="text-muted">/</span>
        <span class="text-muted fw-bold">Consultation Session</span>
    </div>

    <div class="consult-layout animate__animated animate__fadeIn">

        {{-- =================== LEFT PANEL: Patient Info =================== --}}
        <div class="patient-panel">
            {{-- Patient Identity Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:1.5rem;overflow:hidden;">
                <div class="p-4 text-center" style="background:linear-gradient(135deg,#f8faff,#f1f5f9);">
                    <div class="patient-avatar-lg">
                        {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                    </div>
                    <h4 class="fw-bold mb-1">{{ $patient->full_name }}</h4>
                    <span class="badge rounded-pill px-3 py-1"
                        style="background:rgba(99,102,241,0.1);color:#6366f1;font-size:0.78rem;">
                        Patient ID #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div class="px-4 pb-4 pt-2">
                    <div class="info-row">
                        <span class="label">Gender</span>
                        <span class="value">
                            <i
                                class="fas fa-{{ strtolower($patient->gender) === 'male' ? 'mars text-primary' : 'venus text-danger' }} me-1"></i>
                            {{ $patient->gender }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Age</span>
                        <span class="value">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Date of Birth</span>
                        <span class="value">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</span>
                    </div>
                    @if($patient->phone)
                        <div class="info-row">
                            <span class="label">Phone</span>
                            <span class="value">{{ $patient->phone }}</span>
                        </div>
                    @endif
                    @if($patient->address)
                        <div class="info-row">
                            <span class="label">Address</span>
                            <span class="value"
                                style="text-align:right;max-width:160px;font-size:0.82rem;">{{ $patient->address }}</span>
                        </div>
                    @endif
                    <div class="info-row">
                        <span class="label">Visits on Record</span>
                        <span class="value">{{ $patient->medicalRecords->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Medical History Timeline --}}
            <div class="card border-0 shadow-sm" style="border-radius:1.5rem;">
                <div class="card-header px-4 py-3" style="background:white;border-bottom:1px solid #f1f5f9;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3" style="background:rgba(99,102,241,0.1);">
                            <i class="fas fa-history text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Clinical History</h6>
                            <small class="text-muted">Previous visits</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-4" style="max-height:380px;overflow-y:auto;">
                    @forelse($patient->medicalRecords as $i => $record)
                        <div class="history-entry {{ $i > 0 ? 'older' : '' }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <small class="fw-bold" style="font-size:0.75rem;color:#94a3b8;">
                                    {{ $record->visit_date->format('M d, Y') }}
                                </small>
                                <small style="font-size:0.7rem;color:#94a3b8;">Dr. {{ $record->doctor->user->name }}</small>
                            </div>
                            <div class="fw-bold mb-1" style="color:#6366f1;font-size:0.88rem;">{{ $record->diagnosis }}</div>
                            <div class="text-muted" style="font-size:0.8rem;line-height:1.5;">{{ $record->treatment }}</div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-notes-medical fa-2x mb-2" style="color:#e2e8f0;"></i>
                            <p class="text-muted small mb-0">No previous medical records found for this patient.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- =================== RIGHT PANEL: Consultation Form =================== --}}
        <div>
            <div class="card border-0 shadow-sm" style="border-radius:1.5rem;overflow:hidden;">
                {{-- Form Header --}}
                <div class="p-4" style="background:linear-gradient(135deg,#1e293b,#0f172a);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.1);">
                            <i class="fas fa-stethoscope text-white fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-white fw-bold mb-0">New Consultation Notes</h4>
                            <p class="mb-0" style="color:rgba(255,255,255,0.6);font-size:0.875rem;">
                                Session for <strong class="text-white">{{ $patient->full_name }}</strong> &bull;
                                {{ now()->format('l, F j, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="card-body p-4 p-lg-5">
                    <form action="/doctor/medical-records" method="POST">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="visit_date" value="{{ date('Y-m-d') }}">

                        {{-- Diagnosis --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="section-chip"><i class="fas fa-microscope"></i> Diagnosis</span>
                            </div>
                            <label class="form-label">Primary Diagnosis <span class="text-danger">*</span></label>
                            <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror"
                                rows="3" placeholder="e.g. Acute upper respiratory tract infection..."
                                required>{{ old('diagnosis') }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Be specific and include severity level where
                                applicable.</small>
                        </div>

                        {{-- Treatment --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="section-chip"><i class="fas fa-pills"></i> Treatment</span>
                            </div>
                            <label class="form-label">Treatment Plan / Prescription <span
                                    class="text-danger">*</span></label>
                            <textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror"
                                rows="6"
                                placeholder="e.g. Amoxicillin 500mg, 3x daily for 7 days. Rest advised. Follow up in 1 week..."
                                required>{{ old('treatment') }}</textarea>
                            @error('treatment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Include all prescribed medications, dosages, and
                                intervals.</small>
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex align-items-center gap-3 pt-2">
                            <button type="submit" class="save-btn">
                                <i class="fas fa-check-circle me-2"></i> Save & Complete Consultation
                            </button>
                            <a href="{{ url('/doctor/dashboard') }}" class="back-btn">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Quick Tips --}}
            <div class="alert border-0 rounded-4 mt-4 px-4 py-3" style="background:rgba(99,102,241,0.07);">
                <div class="d-flex align-items-start gap-2">
                    <i class="fas fa-lightbulb mt-1" style="color:#6366f1;"></i>
                    <div>
                        <strong style="color:#4f46e5;font-size:0.85rem;">Clinical Tip</strong>
                        <p class="mb-0 text-muted" style="font-size:0.82rem;">
                            Records are saved immediately and linked to the patient's permanent profile. Saved records
                            cannot be deleted — only new entries can be added.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection