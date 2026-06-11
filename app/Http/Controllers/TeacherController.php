<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $teacher = User::findOrFail(Auth::id());
        $totalStudents = $teacher->assignedStudents()->count();
        $totalCourses = Course::count();
        $gradesGiven = Grade::where('teacher_id', Auth::id())->count();
        $submittedGrades = Grade::where('teacher_id', Auth::id())
            ->where('status', 'submitted')
            ->count();
        
        return view('teacher.dashboard', compact('totalStudents', 'totalCourses', 'gradesGiven', 'submittedGrades'));
    }

    // ========== STUDENT MANAGEMENT ==========
    
    // View all students assigned to this teacher
    public function viewStudents()
    {
        $teacher = User::findOrFail(Auth::id());
        $students = $teacher->assignedStudents()->get();
        $searchMessage = null;
        $isSingleStudent = false;
        return view('teacher.students', compact('students', 'searchMessage', 'isSingleStudent'));
    }

    // Search students
    public function searchStudents(Request $request)
    {
        $query = User::where('role', 'student')
            ->whereHas('assignedTeacher', function ($q) {
                $q->where('teacher_id', Auth::id());
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('list_no', 'like', "%{$search}%");
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $students = $query->get();

        // Check if this is a specific student search
        $searchMessage = null;
        $isSingleStudent = false;

        if ($request->filled('search')) {
            if ($students->count() === 1) {
                $student = $students->first();
                $searchMessage = "Found student: {$student->first_name} {$student->last_name} (List No: {$student->list_no})";
                $isSingleStudent = true;
            } elseif ($students->count() === 0) {
                $searchMessage = "No students found matching: '{$request->search}'";
            } else {
                $searchMessage = "Found {$students->count()} students matching: '{$request->search}'";
            }
        }

        if ($request->ajax()) {
            return view('teacher.partials.student_table', compact('students', 'searchMessage', 'isSingleStudent'));
        }

        return view('teacher.students', compact('students', 'searchMessage', 'isSingleStudent'));
    }

    // ========== GRADE MANAGEMENT ==========
    
    // Manage grades page
    public function manageGrades()
    {
        $teacher = User::findOrFail(Auth::id());
        $students = $teacher->assignedStudents()->get();
        $courses = Course::all();
        $grades = Grade::with(['student', 'course'])->where('teacher_id', Auth::id())->get();
        return view('teacher.grades', compact('students', 'courses', 'grades'));
    }

    // Add or update grade
    public function addGrade(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|string|max:2',
            'semester' => 'required|integer|min:1|max:4',
            'academic_year' => 'required|integer'
        ]);

        $studentAssigned = User::where('role', 'student')
            ->whereHas('assignedTeacher', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->where('id', $request->student_id)
            ->exists();

        if (! $studentAssigned) {
            return redirect()->back()->with('error', 'You can only add grades for assigned students.');
        }

        Grade::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'semester' => $request->semester,
                'academic_year' => $request->academic_year,
            ],
            [
                'grade' => $request->grade,
                'teacher_id' => Auth::id(),
            ]
        );

        return redirect()->back()->with('success', 'Grade added/updated successfully!');
    }

    // Submit grades to registrar
    public function submitGrades(Request $request)
    {
        $request->validate([
            'grade_ids' => 'required|array',
            'grade_ids.*' => 'exists:grades,id'
        ]);

        Grade::whereIn('id', $request->grade_ids)
            ->where('teacher_id', Auth::id())
            ->where('status', 'draft')
            ->update(['status' => 'submitted']);

        return redirect()->back()->with('success', 'Grades submitted to registrar successfully!');
    }

    // Delete grade
    public function deleteGrade(int $id)
    {
        $grade = Grade::findOrFail($id);
        if ($grade->teacher_id == Auth::id() && $grade->status == 'draft') {
            $grade->delete();
            return redirect()->back()->with('success', 'Grade deleted successfully!');
        }
        return redirect()->back()->with('error', 'Cannot delete submitted grade or unauthorized action!');
    }

    // ========== ATTENDANCE MANAGEMENT ==========
    
    // Manage attendance page
    public function manageAttendance()
    {
        $teacher = User::findOrFail(Auth::id());
        $students = $teacher->assignedStudents()->get();
        $courses = Course::all();
        $attendances = Attendance::with(['student', 'course'])
            ->where('teacher_id', Auth::id())
            ->latest()
            ->get();
        return view('teacher.attendance', compact('students', 'courses', 'attendances'));
    }

    // Add attendance record
    public function addAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'remarks' => 'nullable|string'
        ]);

        $studentAssigned = User::where('role', 'student')
            ->whereHas('assignedTeacher', function ($q) {
                $q->where('teacher_id', Auth::id());
            })
            ->where('id', $request->student_id)
            ->exists();

        if (! $studentAssigned) {
            return redirect()->back()->with('error', 'You can only manage attendance for assigned students.');
        }

        Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'teacher_id' => Auth::id(),
                'remarks' => $request->remarks,
            ]
        );

        return redirect()->back()->with('success', 'Attendance recorded successfully!');
    }

    // Delete attendance record
    public function deleteAttendance(int $id)
    {
        $attendance = Attendance::findOrFail($id);
        if ($attendance->teacher_id == Auth::id()) {
            $attendance->delete();
            return redirect()->back()->with('success', 'Attendance record deleted successfully!');
        }
        return redirect()->back()->with('error', 'Unauthorized action!');
    }
}