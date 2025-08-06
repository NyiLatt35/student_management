<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use Exception;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $students = Student::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('studentName', 'like', '%' . $query . '%')
                ->orWhere('studentId', 'like', '%' . $query . '%')
                ->orWhereHas('grade', function ($gradeQuery) use ($query) {
                    $gradeQuery->where('gradeId', 'like', '%' . $query . '%');
                });
        })->paginate(5);

        return view("Pages.student.studentList", compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        return view("Pages.student.createStudent", compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateStudentData($request);

        try {

            $student = DB::transaction(function () use ($request) {
                // 1. Create User Account
                $defaultPassword = "password@1234";

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($defaultPassword),
                    'role' => 'user', // Assign a default role
                ]);

                // 2. Get Student Data, passing the new user's ID
                $studentData = $this->getStudentData($request, false, $user->id);

                // Handle file upload
                if ($request->hasFile('photo')) {
                    $path = $request->file('photo')->store('student_photos', 'public');
                    $studentData['photo'] = $path;
                }
                // dd($studentData);
                // 3. Create the Student record
                return Student::create($studentData);
            });

            return redirect()
                ->route('student.index')
                ->with('success', 'Student and user account created successfully.')
                ->with('student', $student);

        } catch (Exception $e) {
            // If anything goes wrong, redirect back with an error
            return redirect()
                ->back()
                ->with(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = Student::where('studentId', $id)->first();
        if (!$details) {
            return redirect()->route('student.index')->with('error', 'Student not found');
        }
        return view('Pages.student.studentDetails', compact('details'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editStudent = Student::where('studentId', $id)->first();

        if (!$editStudent) {
            return redirect()->route('student.index')->with('error', 'Student not found');
        }
        $grades = Grade::all();
        return view('Pages.student.editStudent', compact('editStudent', 'grades'));
    }

      /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $this->validateStudentData($request);
        $student = Student::where('studentId', $id)->first();

        if (!$student) {
            return redirect()->route('student.index')->with('error', 'Student not found');
        }

        $studentData = $this->getStudentData($request, true, $student->studentId, $student->user_id);
        $oldEmail = $student->email;
        $newEmail = $request->email;

        if ($oldEmail !== $newEmail) {
            $request->validate([
                'email' => 'unique:students,email|unique:users,email,' . $student->user->user_id
            ]);

            $student->update(['email' => $newEmail]);
            $student->user->update(['email' => $newEmail]);
        }

        return redirect()->route('student.index')->with('success', 'Student updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::where('studentId', $id)->first();
        if ($student) {
            // Delete the student record
            $student->delete();

            // Delete the associated user record
            User::where('email', $student->email)->delete();

            return redirect()->route('student.index')->with('success', 'Student deleted successfully.');
        }

        return redirect()->back()->with('error', 'Student not found');
    }


    /**
     * Validate Student Data
     */
    public function validateStudentData(Request $request)
    {
        // Updated validation rules
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'grade' => 'required|integer|exists:grades,gradeId',
            'enrollmentDate' => 'required|date',
            'phone' => 'required|string|max:15',
            // IMPORTANT: Ensure email is unique in the 'users' table
            'email' => 'required|email|max:255|unique:users,email' . ($request->route('user') ? ',' . (Student::find($request->route('user'))?->user?->id ?? '') : ''),
            'address' => 'required|string|max:255',
            'parentName' => 'required|string|max:255',
            'parentPhone' => 'required|string|max:15',
        ])->validate();
    }

    /**
     * Get Student Data
     */
    // <?php
    public function getStudentData(Request $request, $isUpdate = false, $existingId = null)

    {
        $grade = Grade::find($request->grade);
        if (!$grade) {
            return null;
        }

        $studentId = $existingId;
        $gradeId = $grade->gradeId;

        if (!$isUpdate) {
            // Creating new student
            $maxId = Student::where('gradeId', $gradeId)
                            ->selectRaw("MAX(CAST(SUBSTRING(studentId, LENGTH('STUG{$gradeId}-') + 1) AS UNSIGNED)) as max_no")
                            ->value('max_no');
            $nextNumber = $maxId ? $maxId + 1 : 1;
            $stuNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $studentId = "STUG{$gradeId}-{$stuNumber}";
        } else {
            // Updating existing student - change ID only if grade changed
            $oldGradeId = $this->extractGradeIdFromStudentId($existingId);

            if ($oldGradeId !== $gradeId) {
                // Get max ID excluding current student
                $maxId = Student::where('gradeId', $gradeId)
                                ->where('id', '!=', Student::where('studentId', $existingId)->value('id'))
                                ->selectRaw("MAX(CAST(SUBSTRING(studentId, LENGTH('STUG{$gradeId}-') + 1) AS UNSIGNED)) as max_no")
                                ->value('max_no');
                $nextNumber = $maxId ? $maxId + 1 : 1;
                $stuNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                $studentId = "STUG{$gradeId}-{$stuNumber}";

                // Renumber students of old grade after moving this student
                if ($oldGradeId) {
                    $this->renumberStudents($oldGradeId);
                }
            }
        }

        // Get user ID from users table by email
        $userId = User::where('email', $request->email)->value('id');

        return [
            'studentId' => $studentId, // Your logic for generating ID
            'user_id' => $userId, // <-- Add the user_id
            'studentName' => $request->name,
            'dateOfBirth' => $request->dob,
            'role' => 'user', // Default role for students
            'gender' => $request->gender,
            'gradeId' => $request->grade,
            'enrollmentDate' => $request->enrollmentDate,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'parentName' => $request->parentName,
            'parentPhone' => $request->parentPhone,
            // 'photo' is handled separately in the store method
        ];
    }

    /**
     * Extract Grade ID from Student ID
     * Format: STUG{gradeId}ID{number}
     */
    private function extractGradeIdFromStudentId($studentId)
    {
        if (!str_starts_with($studentId, 'STUG')) {
            return null;
        }

        // Find position of 'ID' and extract grade ID between 'STUG' and 'ID'
        $idPos = strpos($studentId, 'ID');
        if ($idPos === false) {
            return null;
        }

        return substr($studentId, 4, $idPos - 4);
    }

    /**
     * Renumber students in a grade to maintain sequential numbering
     */
    private function renumberStudents($gradeId)
    {
        $students = Student::where('gradeId', $gradeId)
                           ->orderBy('studentId')
                           ->get();

        $count = 1;
        foreach ($students as $student) {
            $stuNumber = str_pad($count, 5, '0', STR_PAD_LEFT);
            $newStudentId = "STUG{$gradeId}-{$stuNumber}";

            // Only update if the ID actually changed
            if ($student->studentId !== $newStudentId) {
                $student->studentId = $newStudentId;
                $student->save();
            }
            $count++;
        }
    }
}

