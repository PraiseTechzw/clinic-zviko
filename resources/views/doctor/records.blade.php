@extends('layouts.app')

@section('title', 'Medical Records Archive')

@section('content')

    <style>
        .records-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 1.75rem;
            padding: 2.25rem;
            position: relative;
            overflow: hidden;
        }

        .records-header::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.12);
        }

        .records-header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 40px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.08);
        }

        .search-box {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            transition: all 0.2s;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .search-box:focus-within {
            border-color: #6366f1;
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.95rem;
            width: 100%;
            color: #1e293b;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        .record-row {
            transition: background 0.15s;
        }

        .record-row:hover {
            background: #f8faff !important;
        }

        .patient-badge {
            width: 42px;
            height: 42px;
            border-radius: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            flex-shrink: 0;
        }

        .diagnosis-tag {
            display: inline-block;
            background: rgba(99, 102, 241, 0.1);
            color: #6366f1;
            border-radius: 0.65rem;
            padding: 0.3rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .treatment-pill {
            background: #f1f5f9;
            border-radius: 0.65rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            color: #475569;
            max-width: 260px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .date-block .main {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1e293b;
        }

        .date-block .sub {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .pb-0 {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .pb-1 {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .pb-2 {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .pb-3 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .pb-4 {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .pb-5 {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
    </style>

    {{-- ===== HEADER ===== --}}
    <div class="records-header mb-5 animate__animated animate__fadeInDown">
        <div class="position-relative" style="z-index:1;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="p-3 rounded-3" style="background:rgba(255,255,255,0.1);">
                    <i class="fas fa-archive text-white fa-lg"></i>
                </div>
                <div>
                    <h1 class="text-white fw-bold mb-0" style="font-size:1.8rem;letter-spacing:-0.5px;">Medical Records
                        Archive</h1>
                    <p class="mb-0" style="color:rgba(255,255,255,0.65);font-size:0.9rem;">
                        Search and review comprehensive clinical histories across all patients
                    </p>
                </div>
            </div>

            {{-- Search Bar --}}
            <form action="{{ url('/doctor/records') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8 col-lg-7">
                        <div class="search-box">
                            <i class="fas fa-search text-muted"></i>
                            <input type="text" name="search" placeholder="Search patient, diagnosis, or treatment..."
                                value="{{ request('search') }}">
                            @if(request('search'))
                                <a href="{{ url('/doctor/records') }}" class="text-muted ms-2" title="Clear">
                                    <i class="fas fa-times-circle"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn px-4 py-2 fw-bold rounded-3"
                            style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;border:none;box-shadow:0 4px 12px rgba(99,102,241,0.4);">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </div>
            </form>
            @if(request('search'))
                <div class="mt-3">
                    <span class="badge px-3 py-2 rounded-pill"
                        style="background:rgba(255,255,255,0.15);color:white;font-size:0.8rem;">
                        <i class="fas fa-filter me-1"></i>
                        Filtered by: "{{ request('search') }}"
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- ===== RECORDS TABLE ===== --}}
    <div class="card border-0 shadow-sm animate__animated animate__fadeInUp" style="border-radius:1.5rem;overflow:hidden;">
        <div class="card-header d-flex justify-content-between align-items-center px-4 py-4"
            style="background:white;border-bottom:1px solid #f1f5f9;">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-3" style="background:rgba(15,23,42,0.07);">
                    <i class="fas fa-file-medical-alt" style="color:#1e293b;font-size:1.1rem;"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Clinical History</h5>
                    <small class="text-muted">
                        {{ $records->total() }} {{ Str::plural('record', $records->total()) }} found
                        @if(request('search')) for "{{ request('search') }}" @endif
                    </small>
                </div>
            </div>
            <a href="{{ url('/doctor/records') }}"
                class="btn btn-sm btn-light rounded-3 fw-bold text-secondary px-3 {{ request('search') ? '' : 'd-none' }}">
                <i class="fas fa-times me-1"></i> Clear Filter
            </a>
        </div>

        <div class="card-body p-0">
            @forelse($records as $index => $record)
                @if($loop->first)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr class="text-uppercase" style="font-size:0.7rem;letter-spacing:1px;color:#94a3b8;">
                                    <th class="ps-4 py-3">Patient</th>
                                    <th class="py-3">Visit Date</th>
                                    <th class="py-3">Diagnosis</th>
                                    <th class="py-3">Treatment Plan</th>
                                    <th class="py-3 text-end pe-4">Attending Doctor</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                @endif

                            <tr class="record-row animate__animated animate__fadeIn"
                                style="animation-duration:0.35s;animation-delay:{{ $loop->index * 0.04 }}s;">
                                {{-- Patient --}}
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3 py-1">
                                        <div class="patient-badge pb-{{ $loop->index % 6 }}">
                                            {{ strtoupper(substr($record->patient->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size:0.93rem;">
                                                {{ $record->patient->full_name }}
                                            </div>
                                            <small class="text-muted">
                                                ID #{{ str_pad($record->patient->id, 5, '0', STR_PAD_LEFT) }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td>
                                    <div class="date-block">
                                        <div class="main">{{ $record->visit_date->format('M d, Y') }}</div>
                                        <div class="sub">{{ $record->visit_date->diffForHumans() }}</div>
                                    </div>
                                </td>

                                {{-- Diagnosis --}}
                                <td>
                                    <span class="diagnosis-tag">{{ $record->diagnosis }}</span>
                                </td>

                                {{-- Treatment --}}
                                <td>
                                    <span class="treatment-pill" title="{{ $record->treatment }}">
                                        {{ $record->treatment }}
                                    </span>
                                </td>

                                {{-- Doctor --}}
                                <td class="text-end pe-4">
                                    <div class="fw-bold" style="font-size:0.87rem;">Dr. {{ $record->doctor->user->name }}</div>
                                </td>
                            </tr>

                            @if($loop->last)
                                        </tbody>
                                    </table>
                                </div>
                            @endif

            @empty
                {{-- Empty State --}}
                <div class="text-center py-5 px-4">
                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center"
                        style="width:96px;height:96px;border-radius:50%;background:linear-gradient(135deg,#f1f5f9,#e2e8f0);">
                        <i class="fas fa-folder-open fa-2x" style="color:#94a3b8;"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">No Records Found</h4>
                    <p class="text-muted mb-4" style="max-width:360px;margin:0 auto;">
                        @if(request('search'))
                            No records matched "<strong>{{ request('search') }}</strong>". Try a different keyword.
                        @else
                            There are no medical records in the archive yet.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ url('/doctor/records') }}" class="btn rounded-3 px-4 fw-bold"
                            style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;border:none;">
                            <i class="fas fa-times me-2"></i>Clear Filter
                        </a>
                    @endif
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($records->hasPages())
                <div class="px-4 py-3" style="border-top:1px solid #f1f5f9;background:#f8fafc;">
                    {{ $records->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection