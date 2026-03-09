<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', \App\Models\Setting::getValue('clinic_name', 'ClinicEase')) - Digital Appointment System
    </title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #10b981;
            --info: #0ea5e9;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --light: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-width: 280px;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Outfit', sans-serif;
            color: #1e293b;
            overflow-x: hidden;
            margin: 0;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 2.5rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .sidebar-brand i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
        }

        .sidebar-brand h4 {
            font-weight: 700;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .sidebar a {
            color: #94a3b8;
            text-decoration: none;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            margin: 0.2rem 1rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .sidebar a i {
            width: 28px;
            font-size: 1.25rem;
            margin-right: 0.75rem;
            transition: var(--transition);
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }

        .sidebar a.active i {
            color: white;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
            padding-bottom: 3rem;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 1.25rem 2rem;
            sticky-top: true;
        }

        .card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1.5rem;
            box-shadow: var(--card-shadow);
            background: white;
            transition: var(--transition);
            border: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn {
            border-radius: 0.85rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .badge {
            padding: 0.6em 1em;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand text-white">
            <i class="fas fa-hand-holding-medical animate__animated animate__pulse animate__infinite"></i>
            <h4>{{ \App\Models\Setting::getValue('clinic_name', 'ClinicEase') }}</h4>
            <small class="opacity-75">Medical Excellence</small>
        </div>
        
        <div class="nav-links mt-2">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>

            @if(auth()->user()->role === 'admin')
                <div class="px-4 mt-4 mb-2"><small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Administration</small></div>
                <a href="/admin/staff" class="{{ Request::is('admin/staff*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> Manage Staff
                </a>
                <a href="/admin/reports" class="{{ Request::is('admin/reports*') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Reports
                </a>
                <a href="/admin/settings" class="{{ Request::is('admin/settings*') ? 'active' : '' }}">
                    <i class="fas fa-sliders-h"></i> Settings
                </a>
            @endif

            <div class="px-4 mt-4 mb-2"><small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Patient Care</small></div>
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'receptionist')
                <a href="/patients" class="{{ Request::is('patients*') ? 'active' : '' }}">
                    <i class="fas fa-user-injured"></i> Patients
                </a>
                <a href="/appointments" class="{{ Request::is('appointments*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Appointments
                </a>
            @endif

            @if(auth()->user()->role === 'doctor')
                <a href="/doctor/dashboard" class="{{ Request::is('doctor/dashboard*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase-medical"></i> My Consults
                </a>
                <a href="/doctor/records" class="{{ Request::is('doctor/records*') ? 'active' : '' }}">
                    <i class="fas fa-file-medical-alt"></i> History
                </a>
            @endif

            <div class="mt-auto pt-4 border-top border-white border-opacity-10 mx-3 mb-4 mt-5">
                <a href="/profile" class="{{ Request::is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
                <form action="/logout" method="POST" class="px-3 mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2">
                        <i class="fas fa-power-off me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-light sticky-top">
            <div class="container-fluid">
                <button class="btn btn-link d-lg-none p-0 me-3" id="sidebarToggle">
                    <i class="fas fa-bars fa-lg text-dark"></i>
                </button>
                
                <div class="d-none d-md-block">
                    <h5 class="fw-bold mb-0">@yield('title')</h5>
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown">
                            <div class="text-end me-3 d-none d-sm-block">
                                <p class="mb-0 fw-bold">{{ Auth::user()->name }}</p>
                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">{{ Auth::user()->role }}</small>
                            </div>
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-weight: 700; font-size: 1.2rem; box-shadow: 0 4px 6px rgba(99, 102, 241, 0.2);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 mt-3" style="border-radius: 1rem; min-width: 200px;">
                            <li><a class="dropdown-item rounded-3 py-2" href="/profile"><i class="fas fa-user-edit me-2 text-primary"></i> Edit Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="dropdown-item rounded-3 py-2 text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4 p-md-5 animate__animated animate__fadeIn">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible border-0 shadow-sm fade show mb-4 py-3 px-4 rounded-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3 fa-lg"></i>
                        <div>
                            <strong class="d-block">Success!</strong>
                            {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible border-0 shadow-sm fade show mb-4 py-3 px-4 rounded-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                        <div>
                            <strong class="d-block">Error!</strong>
                            {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>