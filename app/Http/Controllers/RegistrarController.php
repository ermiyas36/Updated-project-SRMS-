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
    public function registerStudent(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'registrar') {
            abort(403, 'Unauthorized. Only registrar users can access student registration.');
        }

        $group = $request->query('group');
        $mode = $request->query('mode');

        if (!in_array($mode, ['old', 'new'], true)) {
            $mode = in_array($group, ['freshman', 'remedial'], true) ? 'new' : 'old';
        }

        $teachers = User::where('role', 'teacher')
            ->orderBy('department')
            ->orderBy('first_name')
            ->get();

        return view('registrar.register-student', compact('teachers', 'group', 'mode'));
    }

    // Store new student
    public function storeStudent(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'registrar') {
            abort(403, 'Unauthorized. Only registrar users can register students.');
        }

        $studentGroup = $request->input('student_group', $request->query('group'));
        $mode = $request->input('registration_mode', $request->query('mode'));

        if (!in_array($mode, ['old', 'new'], true)) {
            $mode = in_array($studentGroup, ['freshman', 'remedial'], true) ? 'new' : 'old';
        }

        if ($mode === 'old' && in_array($studentGroup, ['freshman', 'remedial'], true)) {
            return back()->withInput()->withErrors([
                'student_group' => 'Old Regular registration is for department-based students. Use the New Regular page for Freshman or Remedial entries.',
            ]);
        }

        if ($mode === 'new' && !in_array($studentGroup, ['freshman', 'remedial'], true)) {
            return back()->withInput()->withErrors([
                'student_group' => 'New Regular registration only accepts Freshman or Remedial student groups.',
            ]);
        }

        $isRestrictedGroupRegistration = $mode === 'new' && in_array($studentGroup, ['freshman', 'remedial'], true);

        $rules = [
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'year' => 'required|integer|min:1|max:5',
            'student_group' => $isRestrictedGroupRegistration ? 'required|in:freshman,remedial' : 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($isRestrictedGroupRegistration && $studentGroup === 'freshman') {
            $rules['department'] = 'required|in:Natural Science,Social Science';
        }

        if (!$isRestrictedGroupRegistration) {
            $rules['email'] = 'required|email|unique:users';
            $rules['password'] = 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/';
            $rules['department'] = 'required|string';
            $rules['teacher_id'] = 'required|exists:users,id';
        }

        $request->validate($rules, [
            'password.regex' => 'Password must be at least 8 characters with uppercase, lowercase, and number.',
            'password.min' => 'Password must be at least 8 characters.'
        ]);

        $teacher = null;
        if (!$isRestrictedGroupRegistration) {
            $teacher = User::where('id', $request->teacher_id)
                ->where('role', 'teacher')
                ->firstOrFail();

            if ($teacher->department !== $request->department) {
                return back()->withInput()->withErrors(['teacher_id' => 'Selected teacher must belong to the same department as the student.']);
            }
        }

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('student_images', 'public');
        }

        $year = (int) $request->year;

        if ($request->filled('student_group')) {
            if ($request->student_group === 'freshman') {
                $year = 1;
            }

            if ($request->student_group === 'remedial') {
                $year = max($year, 2);
            }
        }

        $listNo = User::generateListNo('student');

        $email = $request->email;
        $password = $request->password;
        $department = $request->department;

        if ($isRestrictedGroupRegistration) {
            $email = sprintf('group-%s-%s@local.test', $studentGroup ?? 'student', $listNo);
            $password = 'Freshman@1234';
            if ($studentGroup === 'remedial') {
                $password = 'Remedial@1234';
            }

            if ($studentGroup === 'freshman') {
                $department = $request->input('department', 'Natural Science');
            } else {
                $department = 'Remedial';
            }
        }

        $student = User::create([
            'list_no' => $listNo,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'student',
            'department' => $department,
            'year' => $year,
            'profile_image' => $imagePath,
        ]);

        if (!$isRestrictedGroupRegistration) {
            $student->assignedTeacher()->attach($teacher->id, [
                'assigned_by' => Auth::id(),
            ]);
        }

        $redirectRoute = $request->filled('student_group')
            ? route('registrar.students', ['group' => $request->student_group])
            : route('registrar.students');

        return redirect($redirectRoute)
            ->with('success', 'Student registered successfully and assigned to the selected teacher!');
    }

    // View all students
    public function viewStudents(Request $request)
    {
        $department = $request->query('department');
        $group = $request->query('group');
        $selectedCollege = $department ? $this->resolveCollegeGroup($department) : null;

        $query = User::where('role', 'student')->latest();

        if ($group === 'freshman') {
            $query->where('year', 1)
                ->whereIn('department', ['Natural Science', 'Social Science']);
        } elseif ($group === 'remedial') {
            $query->where('department', 'Remedial');
        } elseif ($department) {
            if ($department === 'Freshman') {
                $query->where('year', 1)
                    ->whereIn('department', ['Natural Science', 'Social Science']);
            } elseif ($department === 'Remedial') {
                $query->where('department', 'Remedial');
            } elseif (array_key_exists($department, $this->getRegistrarCollegeGroups())) {
                $query->whereIn('department', $this->getRegistrarCollegeGroups()[$department]);
            } else {
                $query->where('department', $department);
            }
        }

        $students = $query->paginate(10)->appends(['department' => $department, 'group' => $group]);

        $freshmanStudents = User::where('role', 'student')
            ->where('year', 1)
            ->whereIn('department', ['Natural Science', 'Social Science'])
            ->count();

        $remedialStudents = User::where('role', 'student')
            ->where('department', 'Remedial')
            ->count();

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

        $groupLabel = match ($group) {
            'freshman' => 'Freshman Students',
            'remedial' => 'Remedial Students (RIM)',
            default => null,
        };

        $filterDepartments = [];
        if ($group) {
            $filterDepartments = collect($collegeGroups)->flatMap(fn($items) => $items)->all();
        } elseif ($selectedCollege) {
            $filterDepartments = $collegeGroups[$selectedCollege] ?? [];
        } elseif ($department && array_key_exists($department, $collegeGroups)) {
            $filterDepartments = $collegeGroups[$department];
        }

        return view('registrar.students', compact('students', 'department', 'group', 'groupLabel', 'collegeGroups', 'selectedCollege', 'freshmanStudents', 'remedialStudents', 'filterDepartments'));
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
            $departmentValues = $this->resolveDepartmentFilter($department);

            $query->whereHas('student', function ($q) use ($departmentValues) {
                $q->whereIn('department', $departmentValues);
            });
        }

        $grades = $query->get();

        // Group grades by department for better organization
        $gradesByDepartment = $grades->groupBy(function ($grade) {
            return $grade->student->department;
        });

        return view('registrar.grades', compact('grades', 'gradesByDepartment', 'department'));
    }

    private function getRegistrarCollegeGroups(): array
    {
        return [
            'Health Academic' => ['Health Academic', 'Nursing', 'Medicine', 'Public Health'],
            'Engineering' => ['Software Engineering', 'Computer Science', 'Information Technology', 'Information Systems', 'Electrical Engineering', 'Mechanical Engineering', 'Civil Engineering'],
            'Social Science' => ['Social Science', 'Psychology', 'Sociology', 'Political Science', 'Economics'],
            'Natural Science' => ['Natural Science', 'Biology', 'Chemistry', 'Physics', 'Environmental Science'],
            'Business & Management' => ['Business', 'Accounting', 'Finance', 'Marketing', 'Management'],
            'Arts & Humanities' => ['Literature', 'History', 'Philosophy', 'Fine Arts', 'Languages'],
            'Mathematics & Statistics' => ['Mathematics', 'Statistics', 'Applied Mathematics'],
            'Other' => ['Law', 'Education', 'Agriculture', 'Other'],
        ];
    }

    private function resolveCollegeGroup(string $department): string
    {
        $collegeGroups = $this->getRegistrarCollegeGroups();
        $normalizedDepartment = trim($department);

        foreach ($collegeGroups as $college => $departments) {
            if (in_array($normalizedDepartment, $departments, true)) {
                return $college;
            }
        }

        return $normalizedDepartment;
    }

    private function resolveDepartmentFilter(string $department): array
    {
        $collegeGroups = $this->getRegistrarCollegeGroups();
        $normalizedDepartment = trim($department);

        if (array_key_exists($normalizedDepartment, $collegeGroups)) {
            return $collegeGroups[$normalizedDepartment];
        }

        return [$normalizedDepartment];
    }
}