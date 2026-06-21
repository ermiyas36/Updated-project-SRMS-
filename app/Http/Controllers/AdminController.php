<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCourses = Course::count();
        $totalUsers = User::count();
        
        return view('admin.dashboard', compact('totalStudents', 'totalTeachers', 'totalCourses', 'totalUsers'));
    }

    // ========== STUDENT MANAGEMENT ==========
    
    // List all students
    public function students(Request $request)
    {
        $department = $request->query('department');
        $selectedFreshmanCategory = $request->query('freshman_group', 'Natural');
        $group = $request->query('group');

        $freshmanCategories = [
            'Natural' => ['Natural Science', 'Biology', 'Chemistry', 'Physics', 'Environmental Science'],
            'Social' => ['Social Science', 'Psychology', 'Sociology', 'Political Science', 'Economics'],
        ];

        $collegeGroups = [
            'Health Academic' => ['Health Academic', 'Nursing', 'Medicine', 'Public Health'],
            'Engineering' => ['Software Engineering', 'Computer Science', 'Information Technology', 'Information Systems', 'Electrical Engineering', 'Mechanical Engineering', 'Civil Engineering'],
            'Social Science' => ['Social Science', 'Psychology', 'Sociology', 'Political Science', 'Economics'],
            'Natural Science' => ['Natural Science', 'Biology', 'Chemistry', 'Physics', 'Environmental Science'],
            'Business & Management' => ['Business', 'Accounting', 'Finance', 'Marketing', 'Management'],
            'Arts & Humanities' => ['Literature', 'History', 'Philosophy', 'Fine Arts', 'Languages'],
            'Mathematics & Statistics' => ['Mathematics', 'Statistics', 'Applied Mathematics'],
            'Other' => ['Law', 'Education', 'Agriculture', 'Other'],
        ];

        $selectedCollege = $department ? $this->resolveCollegeGroup($department, $collegeGroups) : null;

        $allFreshmanDepartments = collect($freshmanCategories)->flatten()->unique()->all();

        $query = User::where('role', 'student')->latest();

        if ($group === 'freshman') {
            $query->where('year', 1)
                ->whereIn('department', $freshmanCategories[$selectedFreshmanCategory] ?? $allFreshmanDepartments);
        } elseif ($group === 'remedial') {
            $query->where('department', 'Remedial');
        } elseif ($department) {
            if ($department === 'Freshman') {
                $query->where('year', 1)
                    ->whereIn('department', $freshmanCategories[$selectedFreshmanCategory] ?? $allFreshmanDepartments);
            } elseif ($department === 'Remedial') {
                $query->where('department', 'Remedial');
            } elseif (array_key_exists($department, $collegeGroups)) {
                $query->whereIn('department', $collegeGroups[$department]);
            } else {
                $query->where('department', $department);
            }
        }

        $students = $query->paginate(10)->appends(['department' => $department, 'group' => $group, 'freshman_group' => $selectedFreshmanCategory]);

        $departments = User::where('role', 'student')
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->select('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department')
            ->filter(function ($name) {
                return !in_array($name, ['Freshman', 'Remedial'], true);
            });

        $departmentCounts = $departments->mapWithKeys(function ($name) {
            return [$name => User::where('role', 'student')->where('department', $name)->count()];
        });

        $freshmanCount = User::where('role', 'student')
            ->where('year', 1)
            ->whereIn('department', $allFreshmanDepartments)
            ->count();

        $remedialCount = User::where('role', 'student')
            ->where('department', 'Remedial')
            ->count();

        $collegeCounts = collect($collegeGroups)->mapWithKeys(function ($departmentsInCollege, $college) use ($departmentCounts) {
            return [$college => collect($departmentsInCollege)->sum(fn($dept) => $departmentCounts[$dept] ?? 0)];
        });

        $selectedCollegeDepartments = $selectedCollege ? ($collegeGroups[$selectedCollege] ?? []) : [];

        return view('admin.students.index', compact(
            'students',
            'departments',
            'department',
            'departmentCounts',
            'collegeGroups',
            'selectedCollege',
            'collegeCounts',
            'selectedCollegeDepartments',
            'freshmanCategories',
            'selectedFreshmanCategory',
            'freshmanCount',
            'remedialCount'
        ));
    }

    private function resolveCollegeGroup(string $department, array $collegeGroups): ?string
    {
        foreach ($collegeGroups as $college => $departments) {
            if (in_array($department, $departments, true)) {
                return $college;
            }
        }

        return null;
    }

    // Show create student form
    public function createStudent()
    {
        return view('admin.students.create');
    }

    // Store new student
    public function storeStudent(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'department' => 'required|string',
            'year' => 'required|integer|min:1|max:5',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'password.regex' => 'Password must be at least 8 characters with uppercase, lowercase, and number.',
            'password.min' => 'Password must be at least 8 characters.'
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('student_images', 'public');
        }

        $listNo = User::generateListNo('student');

        User::create([
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

        return redirect()->route('admin.students')->with('success', 'Student created successfully!');
    }

    // Show edit student form
    public function editStudent(int $id)
    {
        $student = User::findOrFail($id);
        if ($student->role !== 'student') {
            abort(404);
        }
        return view('admin.students.edit', compact('student'));
    }

    // Update student
    public function updateStudent(Request $request, int $id)
    {
        $student = User::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
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

        return redirect()->route('admin.students')->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function deleteStudent(int $id)
    {
        $student = User::findOrFail($id);
        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }
        $student->delete();
        
        return redirect()->route('admin.students')->with('success', 'Student deleted successfully!');
    }

    // ========== TEACHER MANAGEMENT ==========
    
    // List all teachers grouped by department
    public function teachers()
    {
        $allTeachers = User::where('role', 'teacher')->get();
        
        // Group teachers by department
        $teachersByDepartment = $allTeachers->groupBy('department');
        
        return view('admin.teachers.index', compact('teachersByDepartment'));
    }

    // Show create teacher form
    public function createTeacher()
    {
        return view('admin.teachers.create');
    }

    // Store new teacher
    public function storeTeacher(Request $request)
    {
        // Filter out empty values from courses array
        $courses = array_filter($request->input('courses', []), function($value) {
            return $value !== '' && $value !== null;
        });
        
        $request->merge(['courses' => array_values($courses)]);

        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
            'department' => 'required|string',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ], [
            'password.regex' => 'Password must be at least 8 characters with uppercase, lowercase, and number.',
            'password.min' => 'Password must be at least 8 characters.'
        ]);

        $listNo = User::generateListNo('teacher');

        $teacher = User::create([
            'list_no' => $listNo,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'department' => $request->department,
        ]);

        // Assign courses to teacher if provided
        if ($request->courses) {
            $teacher->assignedCourses()->attach($request->courses);
        }

        return redirect()->route('admin.teachers')->with('success', 'Teacher created successfully!');
    }

    // Show edit teacher form
    public function editTeacher(int $id)
    {
        $teacher = User::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    // Update teacher
    public function updateTeacher(Request $request, int $id)
    {
        $teacher = User::findOrFail($id);
        
        // Filter out empty values from courses array
        $courses = array_filter($request->input('courses', []), function($value) {
            return $value !== '' && $value !== null;
        });
        
        $request->merge(['courses' => array_values($courses)]);
        
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'department' => 'required|string',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        $teacher->update($request->only(['first_name', 'last_name', 'email', 'department']));

        // Update course assignments
        $teacher->assignedCourses()->sync($request->courses ?: []);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $teacher->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.teachers')->with('success', 'Teacher updated successfully!');
    }

    // Delete teacher
    public function deleteTeacher(int $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.teachers')->with('success', 'Teacher deleted successfully!');
    }

    // ========== REPORTS ==========
    
    // View reports
    public function reports()
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::all();
        return view('admin.reports', compact('students', 'courses'));
    }
    
    // ========== GRADES MANAGEMENT ==========
    
    // View all grades
    public function grades()
    {
        $grades = Grade::with(['student', 'course'])->latest()->paginate(20);
        return view('admin.grades.index', compact('grades'));
    }

    // Edit grade
    public function editGrade(int $id)
    {
        $grade = Grade::with(['student', 'course'])->findOrFail($id);
        $students = User::where('role', 'student')->get();
        $courses = Course::all();
        return view('admin.grades.edit', compact('grade', 'students', 'courses'));
    }

    // Update grade
    public function updateGrade(Request $request, int $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'grade' => 'required|numeric|min:0|max:100',
            'semester' => 'nullable|string|max:255',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update($request->only(['student_id', 'course_id', 'grade', 'semester']));

        return redirect()->route('admin.grades')->with('success', 'Grade updated successfully!');
    }

    // Delete grade
    public function deleteGrade(int $id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('admin.grades')->with('success', 'Grade deleted successfully!');
    }

    // Get courses by department (AJAX endpoint)
    public function getCoursesByDepartment(Request $request)
    {
        $department = $request->query('department');
        
        if (!$department) {
            return response()->json(['courses' => [], 'subFields' => []]);
        }

        $courses = Course::where('department', $department)
            ->orderBy('sub_field')
            ->orderBy('course_name')
            ->get();

        // Group courses by sub-field for better organization
        $subFields = $courses->whereNotNull('sub_field')
            ->groupBy('sub_field')
            ->keys()
            ->toArray();

        return response()->json([
            'courses' => $courses,
            'subFields' => $subFields
        ]);
    }
}