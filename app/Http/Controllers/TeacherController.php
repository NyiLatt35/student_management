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
        $query = request()->input('query');

        $data['teachers'] = Teacher::with(['subject', 'gradeLevel'])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('teacher_name', 'like', '%' . $query . '%')
                    ->orWhere('teacher_id', 'like', '%' . $query . '%')
                    ->orWhere('teacher_email', 'like', '%' . $query . '%');
                })->orWhereHas('subject', function ($subjectQuery) use ($query) {
                    $subjectQuery->where('sub_name', 'like', '%' . $query . '%');
                })->orWhereHas('gradeLevel', function ($gradeQuery) use ($query) {
                    $gradeQuery->where('gradeName', 'like', '%' . $query . '%');
                });
            })
            ->paginate(5);

        return view('Pages.teacher.teacherList', $data);
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
        // Return the view with teacher details from join subject and grade table
        $data['teacher'] = Teacher::with(['subject', 'gradeLevel'])
            ->where('id', $id)
            ->first();
        // dd($data['teacher']);
        // Check if teacher exists
        if (!$data['teacher']) {
            return redirect()->route('admin.teacher.index')->with('error', 'Teacher not found!');
        }

        return view('Pages.teacher.details', $data);
        // return view('Pages.teacher.details');
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
        try {
            // Find the teacher by ID
            $teacher = Teacher::findOrFail($id);

            // Delete the teacher record
            $teacher->delete();

            // Also delete the associated user record
            User::where('email', $teacher->teacher_email)->delete();

            return redirect()->route('admin.teacher.index')->with('success', 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete teacher: ' . $e->getMessage());
        }

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
