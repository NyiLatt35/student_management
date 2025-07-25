<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Exam;
use App\Models\Student;

class ResultController extends Controller
{
    public function index()
    {
        // Get all results with relationships
        $results = Result::with(['student', 'exam'])->get();

        // For dropdowns in modal
        $exams = Exam::all();
        $students = Student::all();

        return view('Pages.result.result', compact('results', 'exams', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_id' => 'required|exists:students,id',
            'marks' => 'required|numeric|min:0',
        ]);

        Result::create([
            'exam_id' => $request->exam_id,
            'student_id' => $request->student_id,
            'marks' => $request->marks,
        ]);

        return redirect()->route('admin.exam.result')->with('success', 'Result added successfully.');
    }
}
