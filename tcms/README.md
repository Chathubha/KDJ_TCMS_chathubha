# TCMS - Class Management System

A modular class management system built with Laravel 11, MySQL, and Blade + Tailwind CSS.

## Tech Stack
- **Backend:** Laravel 11 (PHP 8.2+)
- **Database:** MySQL / MariaDB (XAMPP)
- **Frontend:** Blade Templates + Tailwind CSS
- **Auth:** Laravel Breeze

## Features
- Role-based access (Admin, Teacher, Student)
- Student management (CRUD, class enrollment)
- Teacher management (CRUD, subject assignment)
- Class management (sections, capacity tracking)
- Subject management (linked to classes and teachers)
- Attendance tracking (bulk marking, history, reports, CSV export)
- Grade management (exams, bulk marks entry, printable report cards)
- Schedule/Timetable (conflict detection, visual grid)
- Dashboard (role-specific with real stats)
- Global search

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL / MariaDB

### Setup Steps

```bash
# 1. Navigate to project
cd tcms

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Create .env file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Configure database in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=class_management
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Create database
mysql -u root -e "CREATE DATABASE class_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 8. Run migrations and seed
php artisan migrate:fresh --seed

# 9. Build frontend assets
npm run build

# 10. Start the server
php artisan serve
```

Visit: http://localhost:8000

## Default Login Credentials

| Role    | Email               | Password |
|---------|---------------------|----------|
| Admin   | admin@tcms.com      | password |
| Teacher | teacher@tcms.com    | password |
| Student | student@tcms.com    | password |

## Database Schema

| Table          | Description |
|----------------|-------------|
| users          | Auth users with roles |
| students       | Student profiles |
| teachers       | Teacher profiles |
| classrooms     | Class sections |
| student_class  | Student-class enrollment (pivot) |
| subjects       | Subjects per class |
| teacher_subject| Teacher-subject assignment (pivot) |
| periods        | Time slots for schedule |
| schedules      | Weekly timetable entries |
| attendances    | Daily attendance records |
| exams          | Exam definitions |
| grades         | Student marks per exam |

## Project Structure

```
app/
├── Http/Controllers/    # Request handlers
├── Models/              # Eloquent models
├── Policies/            # Authorization policies
├── Services/            # Business logic

resources/views/
├── layouts/             # Master layout with sidebar
├── dashboard/           # Role-based dashboards
├── students/            # Student CRUD views
├── teachers/            # Teacher CRUD views
├── classrooms/          # Class CRUD views
├── subjects/            # Subject CRUD views
├── attendance/          # Mark, history, report views
├── grades/              # Exam, marks entry, report card views
├── schedule/            # Timetable views
└── search.blade.php     # Global search

database/seeders/        # Demo data seeders
```
