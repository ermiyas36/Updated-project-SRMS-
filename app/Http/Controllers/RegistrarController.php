<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegistrarController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $newStudents = User::where('role', 'student')
            ->whereRaw('YEAR(created_at) = ?', [date('Y')])
            ->count();
        $graduatingStudents = User::where('role', 'student')
            ->where('year', 5)
            ->count();
            
        return view('registrar.dashboard', compact('totalStudents', 'newStudents', 'graduatingStudents'));
    }

    // Show registration form
    public function registerStudent()
    {
        if (!Auth::check() || Auth::user()->role !== 'registrar') {
            abort(403, 'Unauthorized. Only registrar users can access student registration.');
        }

        $teachers = User::where('role', 'teacher')
            ->orderBy('department')
            ->orderBy('first_name')
            ->get();

        return view('registrar.register-student', compact('teachers'));
    }

    // Store new student
    public function storeStudent(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'registrar') {
            abort(403, 'Unauthorized. Only registrar users can register students.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'department' => 'required|string',
            'year' => 'required|integer|min:1|max:5',
            'teacher_id' => 'required|exists:users,id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'password.regex' => 'Password must be at least 8 characters with uppercase, lowercase, and number.',
            'password.min' => 'Password must be at least 8 characters.'
        ]);

        $teacher = User::where('id', $request->teacher_id)
            ->where('role', 'teacher')
            ->firstOrFail();

        if ($teacher->department !== $request->department) {
            return back()->withInput()->withErrors(['teacher_id' => 'Selected teacher must belong to the same department as the student.']);
        }

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('student_images', 'public');
        }

        $listNo = User::generateListNo('student');

        $student = User::create([
            'list_no' => $listNo,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'department' => $request->department,
            'year' => $request->year,
            'profile_image' => $imagePath,
        ]);

        $student->assignedTeacher()->attach($teacher->id, [
            'assigned_by' => Auth::id(),
        ]);

        return redirect()->route('registrar.students')->with('success', 'Student registered successfully and assigned to the selected teacher!');
    }

    // View all students
    public function viewStudents()
    {
        $students = User::where('role', 'student')->latest()->paginate(10);
        return view('registrar.students', compact('students'));
    }

    // Edit student form
    public function editStudent(int $id)
    {
        $student = User::findOrFail($id);
        if ($student->role !== 'student') {
            abort(404);
        }
        return view('registrar.edit-student', compact('student'));
    }

    // Update student
    public function updateStudent(Request $request, int $id)
    {
        $student = User::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'required|string',
            'year' => 'required|integer|min:1|max:5',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('profile_image')) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            $student->profile_image = $request->file('profile_image')->store('student_images', 'public');
        }

        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'department' => $request->department,
            'year' => $request->year,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $student->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('registrar.students')->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function deleteStudent(int $id)
    {
        $student = User::findOrFail($id);
        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }
        $student->delete();
        
        return redirect()->route('registrar.students')->with('success', 'Student archived successfully!');
    }

    // Archive student
    public function archiveStudent(int $id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        
        return redirect()->back()->with('success', 'Student archived successfully!');
    }

    // Show enrollment page
    public function enrollment()
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::all();
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('registrar.enrollment', compact('students', 'courses', 'enrollments'));
    }

    // Manage enrollment
    public function manageEnrollment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|integer|min:1|max:4',
            'academic_year' => 'required|integer'
        ]);

        Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'semester' => $request->semester,
            'academic_year' => $request->academic_year,
        ]);

        return redirect()->back()->with('success', 'Student enrolled successfully!');
    }

    // Remove enrollment
    public function removeEnrollment(int $id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->back()->with('success', 'Enrollment removed successfully!');
    }

    // View all grades
    public function viewGrades(Request $request)
    {
        $department = $request->query('department');

        $query = Grade::with(['student', 'course', 'teacher'])
            ->where('status', 'submitted');

        if ($department) {
            $query->whereHas('student', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        $grades = $query->get();

        // Group grades by department for better organization
        $gradesByDepartment = $grades->groupBy(function ($grade) {
            return $grade->student->department;
        });

        return view('registrar.grades', compact('grades', 'gradesByDepartment', 'department'));
    }
}