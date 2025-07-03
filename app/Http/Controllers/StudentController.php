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
            // Validate data
            $validated = $this->validateStudentData($request);

            // Get student data
            $studentData = $this->getStudentData($request);

            // Create student
            $student = Student::create($studentData);

            // Get fresh instance with relationships
            $student = $student->fresh();

            // Store in session and redirect
            return redirect()
                ->route('admin.student.create')
                ->with('success', 'Student created successfully.')
                ->with('student', $student);

        } catch (Exception $e) {
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
        return redirect()->back()->withErrors(['error' => 'Student not found']);
    }

    $studentData = $this->getStudentData($request, true, $student->studentId);

    try {
        $student->update($studentData);
        return redirect()->route('admin.student.index')->with('success', 'Student updated successfully');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::where('studentId', $id)->delete();
        return redirect()->route('admin.student.index')->with('success', 'Student deleted successfully');
    }

    // Validation Student Data
    public function validateStudentData(Request $request){
        Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'grade' => 'required|integer',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'dob' => 'nullable|date',
        ])->validate();
    }

    // get student data
    public function getStudentData(Request $request, $isUpdate = false, $existingId = null)
{
    $grade = Grade::find($request->grade);
    if (!$grade) {
        return null;
    }

    $studentId = $existingId;

    if (!$isUpdate) {
        // Creating new student
        $studentCount = Student::where('gradeId', $grade->gradeId)->count();
        do {
            $stuNumber = str_pad($studentCount + 1, 5, '0', STR_PAD_LEFT);
            $studentId = 'STUG' . $grade->gradeId . $stuNumber;
            $studentCount++;
        } while (Student::where('studentId', $studentId)->exists());
    } else {
        // Updating existing student, only change studentId if grade changed
        if ($existingId && $grade->gradeId != substr($existingId, 4, 2)) {
            $studentCount = Student::where('gradeId', $grade->gradeId)->count();
            do {
                $stuNumber = str_pad($studentCount + 1, 5, '0', STR_PAD_LEFT);
                $studentId = 'STUG' . $grade->gradeId . $stuNumber;
                $studentCount++;
            } while (
                Student::where('studentId', $studentId)->exists()
                && $studentId !== $existingId
            );
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

}
