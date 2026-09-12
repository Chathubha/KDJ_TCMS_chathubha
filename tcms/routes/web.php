<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard - role-based
Route::get('/dashboard', function () {
    $user = Auth::user();
    switch ($user->role) {
        case 'admin':
            return view('dashboard.admin');
        case 'teacher':
            return view('dashboard.teacher');
        case 'student':
            return view('dashboard.student');
        default:
            return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin + Teacher routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    Route::resource('classrooms', \App\Http\Controllers\ClassroomController::class);
    Route::resource('subjects', \App\Http\Controllers\SubjectController::class);
    Route::resource('schedule', \App\Http\Controllers\ScheduleController::class);

    // Attendance
    Route::get('attendance', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/mark', [\App\Http\Controllers\AttendanceController::class, 'mark'])->name('attendance.mark');
    Route::post('attendance', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/history', [\App\Http\Controllers\AttendanceController::class, 'history'])->name('attendance.history');
    Route::get('attendance/report', [\App\Http\Controllers\AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('attendance/export', [\App\Http\Controllers\AttendanceController::class, 'export'])->name('attendance.export');

    // Grades
    Route::resource('grades', \App\Http\Controllers\GradeController::class);
    Route::get('grades/{exam}/entry', [\App\Http\Controllers\GradeController::class, 'entry'])->name('grades.entry');
    Route::post('grades/{exam}/store', [\App\Http\Controllers\GradeController::class, 'storeGrades'])->name('grades.store-grades');
    Route::get('grades/{student}/report-card', [\App\Http\Controllers\GradeController::class, 'reportCard'])->name('grades.report-card');

    // Search
    Route::get('search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
});

require __DIR__.'/auth.php';
