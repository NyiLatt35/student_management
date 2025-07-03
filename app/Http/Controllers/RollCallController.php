<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Rollcall;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;

class RollCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        $students = collect([]); // Initialize empty collection
        return view("Pages.rollcall.rollcall", compact('grades','students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $gradeId = $request->input('grade');
        $date = $request->input('date');
        $grades = Grade::all();
        if($gradeId && $date){
            $grade = Grade::find($gradeId);
            $students = Student::where('gradeId', $gradeId)->get();

            $attendances = Rollcall::where([
                'gradeId' => $gradeId,
                'attendanceDate' => $date
            ])->get();
        }
        $attendances = Attendance::all();

        if (!empty($gradeId) && !empty($request->input('date'))) {
            $students = Student::where('gradeId', $gradeId)->get();
            return view("Pages.rollcall.rollcall", [
            'students' => $students,
            'grades' => $grades,
            'attendance' => $attendances,
            ]);
        } else {
            return redirect()->back()->with('error', 'Please provide both grade and date.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'studentId' => 'required',
                'attendanceTypeId' => 'required|integer',
                'gradeId' => 'required',
                'attendanceDate' => 'required|date'
            ]);

            // Check for existing attendance
            $existingRollcall = Rollcall::checkAlreadyAttendance(
                $request->studentId,
                $request->gradeId,
                $request->attendanceDate
            );

            if ($existingRollcall) {
                // Update existing record
                $existingRollcall->attendanceTypeId = $request->attendanceTypeId;
                $existingRollcall->save();
                $rollcall = $existingRollcall;
            } else {
                // Create new record
                $rollcall = Rollcall::create([
                    'studentId' => $request->studentId,
                    'attendanceTypeId' => $request->attendanceTypeId,
                    'gradeId' => $request->gradeId,
                    'attendanceDate' => $request->attendanceDate
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Attendance saved successfully',
                'data' => $rollcall
            ]);

        } catch (Exception $e) {
            Log::error('Rollcall save error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save attendance: ' . $e->getMessage()
            ], 500);
        }
    }

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
}
