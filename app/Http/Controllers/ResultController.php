<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Teacher;
use Symfony\Component\VarDumper\VarDumper;

class ResultController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacherData = Teacher::where('teacher_email', $user->email)->first();

        // Fetch all students for add result modal
        $students = Student::all();

        // Fetch all exams with related subjects and grades
        $exams = Exam::with(['subject', 'grade'])->get();

        // Base results query with relationships
        $resultsQuery = Result::with(['student', 'exam.subject', 'exam.grade']);

        // For teachers: filter results where student grade matches teacher grade
        if ($user && $user->role === 'teacher') {
            $teacher = Teacher::where('teacher_email', $user->email)->first();

            if ($teacher) {
                $resultsQuery->whereHas('student', function ($q) use ($teacher) {
                    $q->where('gradeId', $teacher->grade);
                });
            }
        }

        // Get the results
        $results = $resultsQuery->get();

        return view('Pages.result.result', compact('students', 'exams', 'results', 'teacherData'));
    }


    // public function index()
    // {
    //     $user = Auth::user();

    //     // Fetch all students (for add result modal)
    //     $students = Student::all();

    //     // Fetch all exams with their subjects and grades
    //     $exams = DB::table('exams as e')
    //         ->join('subjects as s', 's.id', '=', 'e.subject_id')
    //         ->join('grades as g', 'g.gradeId', '=', 'e.grade_id')
    //         ->select(
    //             'e.id as id',
    //             'e.exam_name',
    //             's.id as subject_id',
    //             's.sub_name as subject_name',
    //             'g.gradeId as grade_id',
    //             'g.gradeName as grade_name'
    //         )
    //         ->distinct()
    //         ->get();

    //     // Build results query with relationships
    //     // $resultsQuery = Result::with(['student', 'exam.subject', 'exam.grade']);
    //     $resultsQuery = Result::with(['student', 'exam.subject', 'exam.grade']);

    //     if ($user && $user->role === 'teacher') {
    //         $teacher = DB::table('teachers')
    //             ->where('teacher_email', $user->email)
    //             ->first();

    //         if ($teacher) {
    //             $resultsQuery->whereHas('exam', function ($q) use ($teacher) {
    //                 $q->where('grade_id', $teacher->grade)
    //                   ->where('subject_id', $teacher->teacher_subject);
    //             });
    //         }
    //     }

    //     $results = $resultsQuery->get(); // ✅ get() at the very end

    //     dd([
    //         'teacher' => $teacher ?? null,
    //         'total_results' => Result::count(),
    //         'filtered_results' => $results->count(),
    //         'sample' => $results->take(5),
    //     ]);


    //     return view('Pages.result.result', compact('students', 'exams', 'results'));
    // }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|numeric|min:0',
        ]);

        // Check if result already exists
        $exists = Result::where('exam_id', $request->exam_id)
            ->where('student_id', $request->student_id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('exam.result')
                ->with('error', 'Result already exists for this student in this exam.');
        }

        // Fetch exam details
        $exam = Exam::findOrFail($request->exam_id);

        // Determine status
        $status = $request->marks >= ($exam->passing_marks ?? 40) ? 'pass' : 'fail';

        // Save new result
        Result::create([
            'exam_id' => $exam->id,
            'student_id' => $request->student_id,
            'marks_obtained' => $request->marks,
            'total_marks' => $exam->total_marks ?? 100,
            'grade_id' => $exam->grade_id,
            'status' => $status,
        ]);

        return redirect()
            ->route('exam.result')
            ->with('success', 'Result added successfully.');


    }

    public function edit($id)
    {
        // Fetch the result to edit
        $result = Result::findOrFail($id);

        // Fetch all exams and students for the form
        // $exams = Exam::all();
        // $students = Student::all();
        $exams = DB::table('exams as e')
            ->join('subjects as s', 's.id', '=', 'e.subject_id')
            ->join('grades as g', 'g.gradeId', '=', 'e.grade_id')
            ->select(
                'e.id as id',
                'e.exam_name',
                's.id as subject_id',
                's.sub_name as subject_name',
                'g.gradeId as grade_id',
                'g.gradeName as grade_name'
            )
            ->distinct()
            ->get();

        $students = Student::all();


        return view('Pages.result.edit', compact('result', 'exams', 'students'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'exam_id'       => 'required|exists:exams,id',
            'student_id'    => 'required|exists:students,id',
            'marks_obtained'=> 'required|numeric|min:0',
            'status'        => 'required|in:pass,fail',
        ]);

        // Fetch the result record
        $result = Result::findOrFail($id);

        // Fetch the selected exam
        $exam = Exam::with('grade')->findOrFail($request->exam_id);

        // Fetch the selected student
        $student = Student::findOrFail($request->student_id);

        // Ensure the student belongs to the same grade as the exam
        if ($student->gradeId != $exam->grade_id) {
            return redirect()
                ->back()
                ->withErrors(['student_id' => 'Selected student does not belong to this exam’s grade.'])
                ->withInput();
        }

        // Determine status based on marks
        $status = $request->marks_obtained >= ($exam->passing_marks ?? 40) ? 'pass' : 'fail';

        // Update the result
        $result->update([
            'exam_id'        => $exam->id,
            'student_id'     => $student->id,
            'marks_obtained' => $request->marks_obtained,
            'total_marks'    => $exam->total_marks ?? 100,
            'grade_id'       => $exam->grade_id,
            'status'         => $status,
        ]);

        return redirect()
            ->route('exam.result')
            ->with('success', 'Exam result updated successfully.');
}


    public function destroy($id)
    {
        // Find the result to delete
        $result = Result::findOrFail($id);

        // Delete the result
        $result->delete();

        return redirect()
            ->route('exam.result')
            ->with('success', 'Result deleted successfully.');
    }
    public function show($id)
    {
        // Fetch the result details
        $result = Result::with(['student', 'exam.subject', 'exam.grade'])->findOrFail($id);

        return view('Pages.result.detail', compact('result'));
    }
}
