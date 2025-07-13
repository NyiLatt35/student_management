<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Pages.teacher.teacherList');
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        $data['getSubjects'] = Subject::get();
        $data['getGrade'] = Grade::get();
        return view('Pages.teacher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $this->validateTeacherData($request);

            // Get the teacher data
            $teacherData = $this->getTeacherData($request);

            DB::beginTransaction();

            // Create the teacher record
            $teacher = Teacher::create([
                'teacher_id' => $teacherData['teacher_id'],
                'teacher_name' => $teacherData['teacher_name'],
                'teacher_email' => $teacherData['teacher_email'],
                'teacher_phone' => $teacherData['teacher_phone'],
                'teacher_address' => $teacherData['teacher_address'],
                'teacher_subject' => $teacherData['teacher_subject'],
                'grade' => $teacherData['grade'],
                'teacher_password' => $teacherData['teacher_password'],
            ]);

            // Create the user record
            $user = User::create([
                'name' => $teacherData['teacher_name'],
                'email' => $teacherData['teacher_email'],
                'password' => $teacherData['teacher_password'], // Already hashed
                'role' => 'teacher',
            ]);
            // dd([$user, $teacher]);

            DB::commit();

            return redirect()->route('admin.teacher.index')
                            ->with('success', 'Teacher created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput();
        } catch (\Exception $e) {
            DB::rollback();

            // Log the error for debugging
            Log::error('Teacher creation failed: ' . $e->getMessage());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to create teacher: ' . $e->getMessage());
        }
    }

    // public function store(Request $request)
    // {
    //     // Validate the request data
    //     $this->validateTeacherData($request);

    //     // Get the teacher data
    //     $teacherData = $this->getTeacherData($request);

    //     try {
    //         DB::beginTransaction();

    //         // Create the teacher record
    //         $teacher = Teacher::create([
    //             'teacher_id' => $teacherData['teacher_id'],
    //             'teacher_name' => $teacherData['teacher_name'],
    //             'teacher_email' => $teacherData['teacher_email'],
    //             'teacher_phone' => $teacherData['teacher_phone'],
    //             'teacher_address' => $teacherData['teacher_address'],
    //             'teacher_subject' => $teacherData['teacher_subject'],
    //             'grade' => $teacherData['grade'],
    //             'teacher_password' => $teacherData['teacher_password'],
    //         ]);

    //         // Create the user record
    //         $user = User::create([
    //             'name' => $teacherData['teacher_name'],
    //             'email' => $teacherData['teacher_email'],
    //             'password' => $teacherData['teacher_password'],
    //             'role' => 'teacher', // Assuming 'role' is passed in the request
    //         ]);

    //         // dd([$user, $teacher]);
    //         DB::commit();

    //         return redirect()->route('admin.teacher.index')->with('success', 'Teacher created successfully.');

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withInput()->with('error', 'Failed to create teacher: ' . $e->getMessage());
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Validation of teacher data
    public function validateTeacherData(Request $request)
    {
        return $request->validate([
            'teacher_name' => 'required|string|max:255',
            'teacher_email' => 'required|email|max:255|unique:teachers,teacher_email|unique:users,email',
            'teacher_phone' => 'nullable|string|max:15',
            'teacher_address' => 'nullable|string|max:255',
            'teacher_subject' => 'required|exists:subjects,id',
            'grade' => 'required|exists:grades,gradeId',
            'teacher_password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:teacher',
        ], [
            'teacher_name.required' => 'Teacher name is required.',
            'teacher_email.required' => 'Email address is required.',
            'teacher_email.unique' => 'This email is already registered.',
            'teacher_subject.required' => 'Please select a subject.',
            'teacher_subject.exists' => 'Selected subject is invalid.',
            'grade.required' => 'Please select a grade.',
            'grade.exists' => 'Selected grade is invalid.',
            'teacher_password.min' => 'Password must be at least 8 characters.',
            'teacher_password.confirmed' => 'Password confirmation does not match.',
        ]);
    }

    // get Teahcer Data
    public function getTeacherData(Request $request, $isUpdate = false, $existingId = null)
    {
        if (!$isUpdate) {
            // Creating new teacher - generate teacher ID
            $teacherCount = Teacher::count();
            do {
                $teacherCount++;
                $teacherId = 'Tr.' . substr($request->teacher_name, 0, 3). str_pad($teacherCount, 4, '0', STR_PAD_LEFT);
            } while (Teacher::where('teacher_id', $teacherId)->exists());
        }
        // else {
            // Updating existing teacher
            // $existingTeacher = Teacher::find($existingId);
            // $teacherId = $existingTeacher ? $existingTeacher->teacher_id : 'T' . substr($request->name, 0, 3) . '0001';
        // }

        return [
            'teacher_id' => $teacherId,
            'teacher_name' => $request->input('teacher_name'),
            'teacher_email' => $request->input('teacher_email'),
            'teacher_phone' => $request->input('teacher_phone'),
            'teacher_address' => $request->input('teacher_address'),
            'teacher_subject' => $request->input('teacher_subject'),
            'grade' => $request->input('grade'),
            'teacher_password' => Hash::make($request->input('teacher_password')),
            'role' => $request->input('role', 'teacher'),
        ];
    }
}
