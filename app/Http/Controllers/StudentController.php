<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if (!$user || $user->role !== 'student') {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }
    
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $grades = Grade::where('student_id', Auth::id())->with('course')->get();
        $attendance = Attendance::where('student_id', Auth::id())->get();

        $numericGrades = $grades->filter(fn ($grade) => is_numeric($grade->grade));
        $averageGrade = $numericGrades->isNotEmpty()
            ? round($numericGrades->avg(fn ($grade) => (float) $grade->grade), 2)
            : 'N/A';

        $stats = [
            'total_courses' => $grades->count(),
            'average_grade' => $averageGrade,
            'attendance_rate' => $attendance->count() > 0 ? round(($attendance->where('status', 'present')->count() / $attendance->count()) * 100) . '%' : 'N/A',
        ];
        
        return view('student.dashboard', compact('user', 'grades', 'attendance', 'stats'));
    }
    
    // View Profile
    public function viewProfile()
    {
        $student = Auth::user();
        return view('student.profile', compact('student'));
    }
    
    // Update Profile
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);
        
        $user->update($request->only(['first_name', 'last_name', 'email']));
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $user->update(['password' => Hash::make($request->password)]);
        }
        
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }
    
    // View Grades
    public function viewGrades()
    {
        $user = Auth::user();

        $grades = Grade::where('student_id', Auth::id())
            ->with('course')
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester')
            ->get()
            ->groupBy('semester');

        return view('student.grades', compact('grades'));
    }
    
    // View Attendance
    public function viewAttendance()
    {
        $user = Auth::user();
        $attendances = Attendance::where('student_id', Auth::id())->with('course')->get();
        
        // Calculate stats per course
        $stats = $attendances->groupBy('course_id')->map(function ($records) {
            $course = $records->first()->course;
            $present = $records->where('status', 'present')->count();
            $total = $records->count();
            return [
                'course_name' => $course->course_name ?? 'N/A',
                'present' => $present,
                'total' => $total,
                'percentage' => $total > 0 ? round(($present / $total) * 100) : 0,
            ];
        })->values()->toArray();
        
        return view('student.attendance', compact('attendances', 'stats'));
    }
}