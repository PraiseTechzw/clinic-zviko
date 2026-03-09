@extends('layouts.app')

@section('title', 'Physician Workspace')

@section('content')

    {{-- ========================================
    CUSTOM STYLES FOR DOCTOR DASHBOARD
    ======================================== --}}
    <style>
        .doctor-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
            border-radius: 1.75rem;
            position: relative;
            overflow: hidden;
            padding: 2.5rem;
        }

        .doctor-hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .doctor-hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: 80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .doctor-avatar {
            width: 72px;
            height: 72px;
            border-radius: 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .hero-stat-chip {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 0.85rem 1.25rem;
            color: white;
        }

        .hero-stat-chip .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .hero-stat-chip .stat-label {
            font-size: 0.7rem;
            opacity: 0.75;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-dot.online {
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.1);
            }
        }

        .patient-initial {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
            flex-shrink: 0;
            color: white;
        }

        .time-display {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
            color: #1e293b;
        }

        .time-ampm {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }

        .action-btn {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: 0.85rem;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
            white-space: nowrap;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.45);
            color: white;
        }

        .table>tbody>tr {
            transition: background 0.15s;
        }

        .table>tbody>tr:hover {
            background-color: #f8faff;
        }

        .notes-pill {
            background: #f1f5f9;
            border-radius: 0.65rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
            color: #64748b;
            max-width: 240px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .empty-state-box {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #f0f4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: #6366f1;
        }

        .appt-row-index {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
        }

        /* Color palette for patient initials */
        .pi-0 {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .pi-1 {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .pi-2 {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .pi-3 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .pi-4 {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .pi-5 {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
    </style>

    {{-- ========================================
    HERO SECTION
    ======================================== --}}
    <div class="doctor-hero mb-5 animate__animated animate__fadeInDown">
        <div class="d-flex align-items-center flex-wrap gap-4 position-relative" style="z-index:1;">
            <div class="doctor-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="status-dot online"></span>
                    <small class="text-white opacity-75 fw-bold text-uppercase"
                        style="font-size:0.65rem;letter-spacing:1px;">On Duty</small>
                </div>
                <h1 class="text-white fw-bold mb-1" style="font-size:1.9rem;letter-spacing:-0.5px;">
                    Dr. {{ auth()->user()->name }}
                </h1>
                <p class="text-white mb-0" style="opacity:0.75;font-size:0.95rem;">
                    <i class="fas fa-calendar-day me-1"></i>
                    {{ now()->format('l, F jS Y') }} &bull; Today's Consultation Session
                </p>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="hero-stat-chip text-center">
                    <div class="stat-value">{{ $appointments->count() }}</div>
                    <div class="stat-label mt-1">Pending<br>Patients</div>
                </div>
                <div class="hero-stat-chip text-center">
                    <div class="stat-value">{{ now()->format('H:i') }}</div>
                    <div class="stat-label mt-1">Current<br>Time</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================
    APPOINTMENT QUEUE TABLE
    ======================================== --}}
    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="border-radius:1.5rem;overflow:hidden;">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center px-4 py-4"
            style="background:white;border-bottom:1px solid #f1f5f9;">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-3" style="background:rgba(99,102,241,0.1);">
                    <i class="fas fa-list-ul text-primary" style="font-size:1.1rem;"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Upcoming Sessions</h5>
                    <small class="text-muted">Patients awaiting your consultation today</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if($appointments->count() > 0)
                    <span class="badge rounded-pill px-3 py-2 fw-bold"
                        style="background:linear-gradient(135deg,#6366f1,#4f46e5);font-size:0.8rem;">
                        {{ $appointments->count() }} {{ Str::plural('Patient', $appointments->count()) }}
                    </span>
                @endif
                <a href="{{ url('/appointments') }}" class="btn btn-sm btn-light rounded-3 fw-bold text-primary px-3">
                    <i class="fas fa-external-link-alt me-1"></i> Full Schedule
                </a>
            </div>
        </div>

        {{-- Table / Empty State --}}
        <div class="card-body p-0">
            @forelse($appointments as $index => $appt)
                @if($loop->first)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr class="text-uppercase" style="font-size:0.7rem;letter-spacing:1px;color:#94a3b8;">
                                    <th class="ps-4 py-3" style="width:50px;">#</th>
                                    <th class="py-3" style="width:120px;">Time</th>
                                    <th class="py-3">Patient</th>
                                    <th class="py-3 text-center" style="width:140px;">Status</th>
                                    <th class="py-3" style="max-width:240px;">Notes</th>
                                    <th class="py-3 text-end pe-4" style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                @endif

                            <tr class="animate__animated animate__fadeIn"
                                style="animation-duration:0.4s;animation-delay:{{ $loop->index * 0.05 }}s;">
                                {{-- Row # --}}
                                <td class="ps-4">
                                    <div class="appt-row-index">{{ $loop->iteration }}</div>
                                </td>

                                {{-- Time Entry --}}
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <span class="time-display">{{ $appt->appointment_date->format('H:i') }}</span>
                                        <span class="time-ampm mt-1">{{ $appt->appointment_date->format('A') }}</span>
                                    </div>
                                </td>

                                {{-- Patient Profile --}}
                                <td>
                                    <div class="d-flex align-items-center gap-3 py-1">
                                        <div class="patient-initial pi-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($appt->patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-0" style="font-size:0.95rem;">
                                                {{ $appt->patient->full_name }}
                                            </div>
                                            <small class="text-muted">
                                                <i
                                                    class="fas fa-{{ strtolower($appt->patient->gender) === 'male' ? 'mars' : 'venus' }} me-1 opacity-50"></i>
                                                {{ $appt->patient->gender }},
                                                {{ \Carbon\Carbon::parse($appt->patient->date_of_birth)->age }} yrs
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    @php
                                        $status_map = [
                                            'Scheduled' => ['color' => '#6366f1', 'bg' => 'rgba(99,102,241,0.1)', 'icon' => 'clock'],
                                            'Rescheduled' => ['color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.1)', 'icon' => 'calendar-alt'],
                                            'Completed' => ['color' => '#10b981', 'bg' => 'rgba(16,185,129,0.1)', 'icon' => 'check-circle'],
                                            'Cancelled' => ['color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.1)', 'icon' => 'times-circle'],
                                        ];
                                        $s = $status_map[$appt->status] ?? ['color' => '#64748b', 'bg' => 'rgba(100,116,139,0.1)', 'icon' => 'circle'];
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:0.78rem;">
                                        <i class="fas fa-{{ $s['icon'] }} me-1"></i>{{ $appt->status }}
                                    </span>
                                </td>

                                {{-- Notes --}}
                                <td>
                                    @if($appt->notes)
                                        <span class="notes-pill" title="{{ $appt->notes }}">
                                            <i class="fas fa-quote-left me-1 opacity-50"></i>{{ $appt->notes }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:0.8rem;font-style:italic;opacity:0.6;">No intake
                                            notes</span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="pe-4 text-end">
                                    <a href="{{ url('/doctor/consultation/' . $appt->patient->id) }}" class="action-btn">
                                        <i class="fas fa-stethoscope"></i>
                                        <span>Start Consult</span>
                                    </a>
                                </td>
                            </tr>

                            @if($loop->last)
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Footer Summary Bar --}}
                                <div class="d-flex align-items-center justify-content-between px-4 py-3"
                                    style="background:#f8fafc;border-top:1px solid #f1f5f9;">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Showing <strong>{{ $appointments->count() }}</strong>
                                        {{ Str::plural('appointment', $appointments->count()) }} for today
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-sync-alt me-1"></i> Data is live
                                    </small>
                                </div>
                            @endif

            @empty
                {{-- Empty State --}}
                <div class="empty-state-box">
                    <div class="empty-state-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">All Clear for Today!</h4>
                    <p class="text-muted mb-4" style="max-width:380px;margin:0 auto;">
                        You have no pending or rescheduled appointments in your queue right now. Enjoy the downtime or review
                        your historical records.
                    </p>
                    <a href="{{ url('/doctor/records') }}" class="action-btn" style="display:inline-flex;">
                        <i class="fas fa-file-medical-alt"></i> View Medical Records
                    </a>
                </div>
            @endforelse
        </div>
    </div>

@endsection