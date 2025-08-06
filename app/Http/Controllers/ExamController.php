<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = request()->input('query');

        $data['exams'] = Exam::with(['grade', 'subject'])
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($q) use ($query) {
                    $q->where('exam_name', 'like', '%' . $query . '%')
                      ->orWhere('status', 'like', '%' . $query . '%');
                })->orWhereHas('grade', function ($gradeQuery) use ($query) {
                    $gradeQuery->where('gradeName', 'like', '%' . $query . '%');
                })->orWhereHas('subject', function ($subjectQuery) use ($query) {
                    $subjectQuery->where('sub_name', 'like', '%' . $query . '%');
                });
            })
            ->paginate(5);

        $data['grades'] = Grade::all();
        $data['subjects'] = Subject::all();

        return view('Pages.exam.exam', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $grades = Grade::all();
        // $subjects = Subject::all();

        // return view('Pages.exam.create', compact('grades', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

            // Validate the data
            $this->validateExamData($request);

            // Get exam data
            $examData = $this->getExamData($request);
            // dd($examData);
            // Create the exam
            Exam::create($examData);

            return redirect()->route('exam.index')
                           ->with('success', 'Exam created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $exam = Exam::with(['grade', 'subject'])->findOrFail($id);

        return view('Pages.exam.details', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exam = Exam::findOrFail($id);
        $grades = Grade::all();
        $subjects = Subject::all();

        return view('Pages.exam.edit', compact('exam', 'grades', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $exam = Exam::findOrFail($id);

        // Validate the data
        $this->validateExamData($request);

        // Get exam data
        $examData = $this->getExamData($request);

        // Check if any data is changed
        if (empty(array_filter($examData))) {
            return back()->withErrors(['error' => 'No data changed.']);
        }

        // Determine exam date and duration (use new values if provided, else old values)
        $examDate = Carbon::parse($examData['exam_date'] ?? $exam->exam_date);
        $duration = (int) ($examData['duration'] ?? $exam->duration);
        $examEndTime = $examDate->copy()->addMinutes($duration);

        // Check if exam is finished
        $examFinished = now()->greaterThanOrEqualTo($examEndTime);

        // If the exam has finished, force status to completed
        if ($examFinished) {
            $examData['status'] = 'completed';
        }
        // If exam is not finished but user is trying to set status to completed, show error
        elseif (($examData['status'] ?? $exam->status) === 'completed') {
            return back()->with('error' , 'This exam is not finished yet, so it cannot be marked as completed.');
        }

        // Update the exam
        $exam->update($examData);

        return redirect()->route('exam.index')
            ->with('success', 'Exam updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $exam = Exam::findOrFail($id);
            $exam->delete();

            return redirect()->route('exam.index')
                        ->with('success', 'Exam deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                        ->with('error', 'Failed to delete exam: ' . $e->getMessage());
        }
    }

    /**
     * Validate the exam data
     */
    public function validateExamData(Request $request)
    {
        return $request->validate([
            'exam_name' => 'required|string|max:255',
            'exam_date' => 'required|date|after_or_equal:today',
            'exam_time' => 'required|date_format:H:i',
            'grade_id' => 'required|exists:grades,gradeId',
            'duration' => 'required|integer|min:1|max:480', // Max 8 hours
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1|lte:total_marks',
            'subject_id' => 'required|exists:subjects,id',
            'status' => 'nullable|string|in:scheduled,completed,cancelled',
        ], [
            'exam_date.after_or_equal' => 'Exam date must be today or in the future.',
            'passing_marks.lte' => 'Passing marks cannot be greater than total marks.',
            'grade_id.exists' => 'Selected grade does not exist.',
            'subject_id.exists' => 'Selected subject does not exist.',
        ]);
    }

    /**
     * Get exam data from request
     */
    public function getExamData(Request $request)
    {
        return [
            'exam_name' => $request->exam_name,
            'exam_date' => $request->exam_date,
            'exam_time' => $request->exam_time,
            'duration' => $request->duration,
            'total_marks' => $request->total_marks,
            'passing_marks' => $request->passing_marks,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'status' => $request->status ?? 'scheduled',
        ];
    }
}