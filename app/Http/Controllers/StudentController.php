<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\Grade;

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
        try {
            $this->validateStudentData($request);

            $studentData = $this->getStudentData($request);

            $student = Student::create($studentData);

            return redirect()
                ->route('admin.student.create')
                ->with('success', 'Student created successfully.')
                ->with('student', $student);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()])
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
            return redirect()->route('admin.student.index')->with('error', 'Student not found');
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
            return redirect()->route('admin.student.index')->with('error', 'Student not found');
        }
        $grades = Grade::all();
        return view('Pages.student.editStudent', compact('editStudent', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateStudentData($request);
        $student = Student::where('studentId', $id)->first();

        if (!$student) {
            return redirect()->route('admin.student.index')->with('error', 'Student not found');
        }

        $studentData = $this->getStudentData($request, true, $student->studentId);
        $student->update($studentData);

        return redirect()->route('admin.student.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::where('studentId', $id)->delete();
        return redirect()->route('admin.student.index')->with('success', 'Student deleted successfully');
    }


    /**
     * Validate Student Data
     */
    public function validateStudentData(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'grade' => 'required|integer',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'dob' => 'nullable|date',
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

        return [
            'studentId' => $studentId,
            'studentName' => $request->name,
            'gradeId' => $request->grade,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'dateOfBirth' => $request->dob,
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
