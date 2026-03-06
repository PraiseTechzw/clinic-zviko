# ClinicEase – Digital Appointment and Patient Record System

ClinicEase is a secure web-based clinic management system designed for small to medium clinics. It handles patient registration, appointment scheduling, and medical records with role-based access control.

## Technology Stack
- **Backend:** Laravel (PHP 8.2+)
- **Frontend:** Blade Templates with Bootstrap 5
- **Database:** MySQL
- **Design:** Modern, clean, and responsive

## Features
- **Authentication:** Secure login with role-based redirection.
- **Admin Dashboard:** System statistics, staff management, and overview.
- **Receptionist Interface:** Patient registration and appointment booking.
- **Doctor Interface:** View assigned appointments and record consultation notes.
- **Patient Management:** Searchable patient records and profiles.
- **Medical Records:** History of visits, diagnoses, and treatments.

## Installation Instructions
1. Ensure **XAMPP** is installed and MySQL is running.
2. Clone or copy the project files to your web directory.
3. Configure `.env` with your database credentials (default: `clinisease_db`, `root`, no password).
4. Run the following commands:
   ```bash
   php artisan migrate:fresh --seed
   php artisan key:generate
   ```
5. Start the local development server:
   ```bash
   php artisan serve
   ```
6. Access the application at `http://localhost:8000`.

## Seeded Accounts (Password: `password`)
- **Admin:** `admin@clinic.com`
- **Receptionist:** `reception@clinic.com`
- **Doctor:** `doctor@clinic.com`

## Security
- Password hashing via Bcrypt.
- Middleware protection for Admin, Receptionist, and Doctor routes.
- CSRF protection on all forms.
- SQL injection prevention via Eloquent ORM.
