@extends('layouts.app')

@section('title', 'Physician Workspace')

@section('content')

    <style>
        /* ── Hero ── */
        .doctor-hero {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
            border-radius: 1.75rem;
            position: relative;
            overflow: hidden;
            padding: 2.25rem 2.5rem;
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
            width: 68px;
            height: 68px;
            border-radius: 1.25rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
            animation: dot-pulse 2s infinite;
        }

        @keyframes dot-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.1);
            }
        }

        /* ── Stat Chips inside hero ── */
        .hero-chip {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 0.9rem 1.25rem;
            color: white;
            text-align: center;
            min-width: 110px;
        }

        .hero-chip .val {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
        }

        .hero-chip .lbl {
            font-size: 0.65rem;
            opacity: .75;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* ── Quick stat cards (row below hero) ── */
        .q-stat {
            border-radius: 1.25rem;
            padding: 1.35rem 1.5rem;
            border: none;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            background: white;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform .2s;
        }

        .q-stat:hover {
            transform: translateY(-3px);
        }

        .q-stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 1rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .q-stat .title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: #94a3b8;
            font-weight: 600;
        }

        .q-stat .value {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        /* ── Next-Up card ── */
        .next-up-card {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-radius: 1.5rem;
            padding: 1.75rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .next-up-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.15);
        }

        .next-up-time {
            font-size: 3rem;
            font-weight: 900;
            color: white;
            line-height: 1;
            letter-spacing: -2px;
        }

        .consult-btn {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            border-radius: .85rem;
            padding: .7rem 1.5rem;
            font-weight: 700;
            font-size: .875rem;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, .4);
            transition: all .25s;
            white-space: nowrap;
            text-decoration: none;
        }

        .consult-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, .5);
            color: white;
        }

        .consult-btn.green {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 12px rgba(16, 185, 129, .4);
        }

        .consult-btn.green:hover {
            box-shadow: 0 8px 20px rgba(16, 185, 129, .5);
        }

        /* ── Table styling ── */
        .patient-initial {
            width: 46px;
            height: 46px;
            border-radius: .9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            font-weight: 700;
            flex-shrink: 0;
            color: white;
        }

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

        .time-big {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            line-height: 1;
        }

        .time-sm {
            font-size: .65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        .notes-pill {
            background: #f1f5f9;
            border-radius: .65rem;
            padding: .35rem .75rem;
            font-size: .8rem;
            color: #64748b;
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .row-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            color: #64748b;
        }

        .table>tbody>tr {
            transition: background .15s;
        }

        .table>tbody>tr:hover {
            background: #f8faff;
        }

        .empty-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e0e7ff, #f0f4ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.4rem;
            color: #6366f1;
        }
    </style>

    {{-- ══════════════════════════════════════════
    HERO
    ══════════════════════════════════════════ --}}
    <div class="doctor-hero mb-4 animate__animated animate__fadeInDown">
        <div class="d-flex align-items-center flex-wrap gap-4 position-relative" style="z-index:1;">
            <div class="doctor-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="status-dot"></span>
                    <small class="text-white fw-bold text-uppercase"
                        style="font-size:.65rem;letter-spacing:1px;opacity:.8;">On Duty</small>
                </div>
                <h1 class="text-white fw-bold mb-1" style="font-size:1.85rem;letter-spacing:-.5px;">
                    Dr. {{ auth()->user()->name }}
                </h1>
                <p class="text-white mb-0" style="opacity:.7;font-size:.9rem;">
                    <i class="fas fa-calendar-day me-1"></i>
                    {{ now()->format('l, F jS Y') }}
                </p>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="hero-chip">
                    <div class="val">{{ $stats['today_count'] }}</div>
                    <div class="lbl">Today<br>Pending</div>
                </div>
                <div class="hero-chip">
                    <div class="val">{{ $stats['completed_today'] }}</div>
                    <div class="lbl">Completed<br>Today</div>
                </div>
                <div class="hero-chip">
                    <div class="val">{{ $stats['total_pending'] }}</div>
                    <div class="lbl">Total<br>Queue</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
    NEXT-UP CARD + QUICK STATS
    ══════════════════════════════════════════ --}}
    <div class="row g-4 mb-4 animate__animated animate__fadeInUp">

        {{-- Next Appointment Highlight --}}
        <div class="col-lg-6">
            <div class="next-up-card h-100">
                <div class="position-relative" style="z-index:1;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="p-2 rounded-3" style="background:rgba(99,102,241,.25);">
                            <i class="fas fa-bolt text-white" style="font-size:.9rem;"></i>
                        </div>
                        <small class="text-white fw-bold text-uppercase"
                            style="font-size:.68rem;letter-spacing:1px;opacity:.8;">Next Up</small>
                    </div>

                    @if($stats['next_appointment'])
                        @php $next = $stats['next_appointment']; @endphp
                        <div class="d-flex align-items-end gap-3 mb-3">
                            <div class="next-up-time">{{ $next->appointment_date->format('H:i') }}</div>
                            <span class="text-white fw-bold mb-1" style="opacity:.6;font-size:.8rem;">
                                {{ $next->appointment_date->format('A') }} &bull; {{ $next->appointment_date->format('M j') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="patient-initial pi-0" style="width:44px;height:44px;font-size:1rem;">
                                {{ strtoupper(substr($next->patient->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-white fw-bold" style="font-size:1.05rem;">{{ $next->patient->full_name }}</div>
                                <small style="color:rgba(255,255,255,.55);">
                                    <i
                                        class="fas fa-{{ strtolower($next->patient->gender) === 'male' ? 'mars' : 'venus' }} me-1"></i>
                                    {{ $next->patient->gender }},
                                    {{ \Carbon\Carbon::parse($next->patient->date_of_birth)->age }} yrs
                                </small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ url('/doctor/consultation/' . $next->patient->id) }}" class="consult-btn green">
                                <i class="fas fa-stethoscope"></i> Start Consult
                            </a>
                            <span class="badge px-3 py-2 rounded-pill"
                                style="background:rgba(245,158,11,0.2);color:#fbbf24;font-size:.75rem;">
                                <i class="fas fa-clock me-1"></i> {{ $next->appointment_date->diffForHumans() }}
                            </span>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-times fa-2x mb-3" style="color:rgba(255,255,255,.3);"></i>
                            <h5 class="text-white mb-1">No Upcoming Appointments</h5>
                            <p style="color:rgba(255,255,255,.5);font-size:.87rem;margin:0;">All appointments have been
                                attended.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Stats Column --}}
        <div class="col-lg-6">
            <div class="d-flex flex-column gap-3 h-100">

                {{-- Today --}}
                <div class="q-stat flex-fill">
                    <div class="q-stat-icon" style="background:rgba(99,102,241,.1);">
                        <i class="fas fa-calendar-day" style="color:#6366f1;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="title">Today's Appointments</div>
                        <div class="value">{{ $stats['today_count'] }}</div>
                    </div>
                    @if($stats['today_count'] > 0)
                        <span class="badge rounded-pill px-3 py-2 fw-semibold"
                            style="background:rgba(99,102,241,.1);color:#6366f1;font-size:.75rem;">
                            <i class="fas fa-circle-dot me-1" style="font-size:.5rem;"></i>Active
                        </span>
                    @endif
                </div>

                {{-- Completed --}}
                <div class="q-stat flex-fill">
                    <div class="q-stat-icon" style="background:rgba(16,185,129,.1);">
                        <i class="fas fa-check-circle" style="color:#10b981;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="title">Completed Today</div>
                        <div class="value">{{ $stats['completed_today'] }}</div>
                    </div>
                    @if($stats['completed_today'] > 0)
                        <span class="badge rounded-pill px-3 py-2 fw-semibold"
                            style="background:rgba(16,185,129,.1);color:#10b981;font-size:.75rem;">
                            Done ✓
                        </span>
                    @endif
                </div>

                {{-- Full queue --}}
                <div class="q-stat flex-fill">
                    <div class="q-stat-icon" style="background:rgba(14,165,233,.1);">
                        <i class="fas fa-list-ol" style="color:#0ea5e9;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="title">Total Pending Queue</div>
                        <div class="value">{{ $stats['total_pending'] }}</div>
                    </div>
                    <a href="#appointment-table" class="btn btn-sm rounded-3 fw-bold px-3"
                        style="background:rgba(14,165,233,.1);color:#0ea5e9;border:none;font-size:.78rem;">
                        View All
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
    FULL APPOINTMENT QUEUE TABLE
    ══════════════════════════════════════════ --}}
    <div id="appointment-table" class="card border-0 shadow-sm animate__animated animate__fadeInUp"
        style="border-radius:1.5rem;overflow:hidden;animation-delay:.15s;">

        <div class="card-header d-flex justify-content-between align-items-center px-4 py-4"
            style="background:white;border-bottom:1px solid #f1f5f9;">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-3" style="background:rgba(99,102,241,.1);">
                    <i class="fas fa-list-ul text-primary" style="font-size:1.1rem;"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Full Consultation Queue</h5>
                    <small class="text-muted">All pending &amp; rescheduled appointments</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if($appointments->count() > 0)
                    <span class="badge rounded-pill px-3 py-2 fw-bold"
                        style="background:linear-gradient(135deg,#6366f1,#4f46e5);font-size:.8rem;">
                        {{ $appointments->count() }} {{ Str::plural('Patient', $appointments->count()) }}
                    </span>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            @forelse($appointments as $index => $appt)
                @if($loop->first)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr class="text-uppercase" style="font-size:.7rem;letter-spacing:1px;color:#94a3b8;">
                                    <th class="ps-4 py-3" style="width:46px;">#</th>
                                    <th class="py-3" style="width:110px;">Time</th>
                                    <th class="py-3">Patient</th>
                                    <th class="py-3 text-center" style="width:150px;">Status</th>
                                    <th class="py-3" style="max-width:230px;">Intake Notes</th>
                                    <th class="py-3 text-end pe-4" style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                @endif

                            <tr class="animate__animated animate__fadeIn"
                                style="animation-duration:.35s;animation-delay:{{ $loop->index * 0.05 }}s;">
                                <td class="ps-4">
                                    <div class="row-num">{{ $loop->iteration }}</div>
                                </td>
                                <td>
                                    <div class="time-big">{{ $appt->appointment_date->format('H:i') }}</div>
                                    <div class="time-sm mt-1">{{ $appt->appointment_date->format('A · M j') }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3 py-1">
                                        <div class="patient-initial pi-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($appt->patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size:.95rem;">
                                                {{ $appt->patient->full_name }}</div>
                                            <small class="text-muted">
                                                <i
                                                    class="fas fa-{{ strtolower($appt->patient->gender) === 'male' ? 'mars' : 'venus' }} me-1 opacity-50"></i>
                                                {{ $appt->patient->gender }},
                                                {{ \Carbon\Carbon::parse($appt->patient->date_of_birth)->age }} yrs
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusMap = [
                                            'Scheduled' => ['color' => '#6366f1', 'bg' => 'rgba(99,102,241,.1)', 'icon' => 'clock'],
                                            'Rescheduled' => ['color' => '#f59e0b', 'bg' => 'rgba(245,158,11,.1)', 'icon' => 'calendar-alt'],
                                            'Completed' => ['color' => '#10b981', 'bg' => 'rgba(16,185,129,.1)', 'icon' => 'check-circle'],
                                            'Cancelled' => ['color' => '#ef4444', 'bg' => 'rgba(239,68,68,.1)', 'icon' => 'times-circle'],
                                        ];
                                        $s = $statusMap[$appt->status] ?? ['color' => '#64748b', 'bg' => 'rgba(100,116,139,.1)', 'icon' => 'circle'];
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                        style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:.78rem;">
                                        <i class="fas fa-{{ $s['icon'] }} me-1"></i>{{ $appt->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($appt->notes)
                                        <span class="notes-pill" title="{{ $appt->notes }}">
                                            <i class="fas fa-quote-left me-1 opacity-50"></i>{{ $appt->notes }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size:.8rem;font-style:italic;opacity:.55;">No intake
                                            notes.</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ url('/doctor/consultation/' . $appt->patient->id) }}" class="consult-btn">
                                        <i class="fas fa-stethoscope"></i><span>Start Consult</span>
                                    </a>
                                </td>
                            </tr>

                            @if($loop->last)
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex align-items-center justify-content-between px-4 py-3"
                                    style="background:#f8fafc;border-top:1px solid #f1f5f9;">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Showing <strong>{{ $appointments->count() }}</strong>
                                        {{ Str::plural('appointment', $appointments->count()) }}
                                    </small>
                                    <small class="text-muted"><i class="fas fa-sync-alt me-1"></i> Live data</small>
                                </div>
                            @endif

            @empty
                <div class="text-center py-5 px-4">
                    <div class="empty-icon"><i class="fas fa-calendar-check"></i></div>
                    <h4 class="fw-bold text-dark mb-2">Queue is Clear!</h4>
                    <p class="text-muted mb-4" style="max-width:380px;margin:0 auto;">
                        You have no pending or rescheduled appointments in your queue right now.
                    </p>
                    <a href="{{ url('/doctor/records') }}" class="consult-btn">
                        <i class="fas fa-file-medical-alt"></i> View Medical Records
                    </a>
                </div>
            @endforelse
        </div>
    </div>

@endsection