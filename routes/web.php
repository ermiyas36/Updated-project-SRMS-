<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegistrarController;

// Apply web middleware group to all routes
Route::middleware(['web'])->group(function () {


// Public routes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes - WITH AUTH MIDDLEWARE
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('students.delete');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers');
    Route::get('/teachers/create', [AdminController::class, 'createTeacher'])->name('teachers.create');
    Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [AdminController::class, 'editTeacher'])->name('teachers.edit');
    Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('teachers.update');
    Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('teachers.delete');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
    Route::get('/grades/{id}/edit', [AdminController::class, 'editGrade'])->name('grades.edit');
    Route::put('/grades/{id}', [AdminController::class, 'updateGrade'])->name('grades.update');
    Route::delete('/grades/{id}', [AdminController::class, 'deleteGrade'])->name('grades.delete');
    Route::get('/courses/by-department', [AdminController::class, 'getCoursesByDepartment'])->name('courses.by-department');
});

// Teacher routes - WITH AUTH MIDDLEWARE
Route::prefix('teacher')->name('teacher.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [TeacherController::class, 'viewStudents'])->name('students');
    Route::get('/students/search', [TeacherController::class, 'searchStudents'])->name('students.search');
    Route::get('/grades', [TeacherController::class, 'manageGrades'])->name('grades');
    Route::post('/grades/add', [TeacherController::class, 'addGrade'])->name('add-grade');
    Route::post('/grades/submit', [TeacherController::class, 'submitGrades'])->name('submit-grades');
    Route::delete('/grades/{id}', [TeacherController::class, 'deleteGrade'])->name('delete-grade');
    Route::get('/attendance', [TeacherController::class, 'manageAttendance'])->name('attendance');
    Route::post('/attendance/add', [TeacherController::class, 'addAttendance'])->name('add-attendance');
    Route::delete('/attendance/{id}', [TeacherController::class, 'deleteAttendance'])->name('delete-attendance');
});

// Student routes - WITH AUTH MIDDLEWARE
Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'viewProfile'])->name('profile');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('update-profile');
    Route::get('/grades', [StudentController::class, 'viewGrades'])->name('grades');
    Route::get('/attendance', [StudentController::class, 'viewAttendance'])->name('attendance');
});

// Registrar routes - WITH AUTH + REGISTRAR PERMISSION
Route::prefix('registrar')->name('registrar.')->middleware(['auth', 'registrar'])->group(function () {
    Route::get('/dashboard', [RegistrarController::class, 'dashboard'])->name('dashboard');
    Route::get('/register-student', [RegistrarController::class, 'registerStudent'])->name('register-student');
    Route::post('/students', [RegistrarController::class, 'storeStudent'])->name('students.store');
    Route::get('/students', [RegistrarController::class, 'viewStudents'])->name('students');
    Route::get('/students/{id}/edit', [RegistrarController::class, 'editStudent'])->name('students.edit');
    Route::put('/students/{id}', [RegistrarController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [RegistrarController::class, 'deleteStudent'])->name('students.delete');
    Route::post('/students/{id}/archive', [RegistrarController::class, 'archiveStudent'])->name('students.archive');
    Route::get('/enrollment', [RegistrarController::class, 'enrollment'])->name('enrollment');
    Route::post('/enrollment', [RegistrarController::class, 'manageEnrollment'])->name('enrollment.manage');
    Route::delete('/enrollment/{id}', [RegistrarController::class, 'removeEnrollment'])->name('enrollment.remove');
    Route::get('/grades', [RegistrarController::class, 'viewGrades'])->name('grades');
});

// Dashboard redirect
Route::get('/dashboard', function() {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    $user = Auth::user();
    
    if ($user->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role == 'teacher') {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->role == 'student') {
        return redirect()->route('student.dashboard');
    } elseif ($user->role == 'registrar') {
        return redirect()->route('registrar.dashboard');
    } else {
        return redirect('/');
    }
})->middleware('auth');
});