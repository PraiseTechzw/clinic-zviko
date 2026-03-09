# ClinicEase – Complete Digital Health Management System

ClinicEase is a premium, secure web-based clinic management system designed to streamline patient operations for modern healthcare facilities. Built on **Laravel 11**, it provides a robust infrastructure for handling patient records, appointment scheduling, and role-based clinical workflows.

## 🚀 Key Features

### 🔐 Multi-Role Access Control
*   **Administrator:** Complete system oversight, staff management (admins, doctors, receptionists), and in-depth analytics.
*   **Receptionist:** Front-desk operations including patient on-boarding, appointment booking, and schedule maintenance.
*   **Doctor:** Clinical interface for managing assigned appointments and recording detailed consultation notes.

### 🏥 Patient Management
*   Secure storage of demographic data.
*   Centralized medical history and appointment logs.
*   Searchable patient directory for rapid retrieval.

### 📅 Advanced Scheduling
*   Real-time appointment status tracking (Scheduled, Rescheduled, Cancelled, Completed).
*   Dynamic doctor allocation.
*   Initial consultation notes logging.

### 📊 Reports & Analytics
*   Visual distribution of patient demographics.
*   Appointment volume and status summaries.
*   Doctor performance and consultation activity logs.

## 🛠️ Technology Stack
*   **Core Framework:** [Laravel 11](https://laravel.com/) (PHP 8.2+)
*   **Database:** MySQL / MariaDB
*   **Frontend Logic:** Blade Templates
*   **Styling:** Bootstrap 5 with custom "Glassmorphism" UI elements
*   **Icons:** Font Awesome 6
*   **Build Tool:** Vite

## ⚙️ Installation Guide

### Prerequisites
1.  **XAMPP / Laragon / Local PHP Environment** (PHP 8.2+ required).
2.  **Composer** installed globally.
3.  **Node.js & NPM** for frontend asset compilation.

### Setup Steps
1.  **Clone the repository:**
    ```bash
    git clone https://github.com/PraiseTechzw/clinic-zviko.git
    cd clinic-zviko
    ```

2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node Dependencies:**
    ```bash
    npm install
    ```

4.  **Configure Environment:**
    *   Rename `.env.example` to `.env`.
    *   Set `DB_DATABASE=clinisease_db` and your MySQL credentials.

5.  **Initialize Database:**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

6.  **Compile Assets:**
    ```bash
    npm run dev
    ```

7.  **Run Server:**
    ```bash
    php artisan serve
    ```

Access the app at `http://localhost:8000`.

## 🧪 Demo Credentials (Password: `password`)
*   **Admin:** `admin@clinic.com`
*   **Receptionist:** `reception@clinic.com`
*   **Doctor:** `doctor@clinic.com`

---
*Built with ❤️ by PraiseTech for modern healthcare.*
