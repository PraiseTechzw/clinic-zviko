<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ClinicEase') - Digital Appointment System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #2c3e50;
            color: white;
        }

        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #34495e;
            color: white;
        }

        .navbar {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #f1f1f1;
            font-weight: bold;
        }

        .stat-card {
            border-left: 4px solid #3498db;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-none d-md-block p-0">
                <div class="p-4 text-center">
                    <h4>ClinicEase</h4>
                    <small class="text-muted">Management System</small>
                </div>
                <div class="mt-4">
                    <a href="/" class="{{ Request::is('/') ? 'active' : '' }}"><i class="fas fa-home me-2"></i>
                        Dashboard</a>

                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/staff" class="{{ Request::is('admin/staff*') ? 'active' : '' }}"><i
                                class="fas fa-users-cog me-2"></i> Manage Staff</a>
                        <a href="/admin/reports" class="{{ Request::is('admin/reports*') ? 'active' : '' }}"><i
                                class="fas fa-chart-bar me-2"></i> Reports</a>
                    @endif

                    @if(auth()->user()->role === 'receptionist')
                        <a href="/patients" class="{{ Request::is('patients*') ? 'active' : '' }}"><i
                                class="fas fa-user-injured me-2"></i> Patients</a>
                        <a href="/appointments" class="{{ Request::is('appointments*') ? 'active' : '' }}"><i
                                class="fas fa-calendar-alt me-2"></i> Appointments</a>
                    @endif

                    @if(auth()->user()->role === 'doctor')
                        <a href="/doctor/appointments" class="{{ Request::is('doctor/appointments*') ? 'active' : '' }}"><i
                                class="fas fa-calendar-check me-2"></i> My Appointments</a>
                    @endif

                    <div class="mt-4 p-3">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100 btn-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <nav class="navbar navbar-expand-lg px-4 sticky-top">
                    <div class="container-fluid">
                        <span class="navbar-brand d-md-none">ClinicEase</span>
                        <div class="ms-auto d-flex align-items-center">
                            <span class="me-3 text-muted">Welcome, <strong>{{ Auth::user()->name }}</strong>
                                ({{ ucfirst(Auth::user()->role) }})</span>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>