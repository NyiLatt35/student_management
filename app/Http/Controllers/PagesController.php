<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;


class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Summary counts
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalResults = Result::count();

        // Line Chart Data: average marks for the last 6 months
        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M');

            $average = Result::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->avg('marks_obtained');

            $chartData[] = round($average ?? 0, 2);
        }

        // Pie Chart Data: pass vs fail counts
        $passCount = Result::where('status', 'pass')->count();
        $failCount = Result::where('status', 'fail')->count();

        // Example tasks (replace with your own logic)
        $tasks = [
            ['title' => 'Math Homework', 'progress' => 80],
            ['title' => 'Science Project', 'progress' => 60],
            ['title' => 'English Essay', 'progress' => 40],
        ];

        // Example top students (replace with your own logic)
        $topStudents = Result::select('student_id', DB::raw('AVG(marks_obtained) as average_score'))
            ->groupBy('student_id')
            ->orderByDesc('average_score')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->student->studentName ?? 'Unknown',
                    'score' => round($item->average_score, 2),
                    'avatar' => 'https://via.placeholder.com/35'
                ];
            });

            if(Auth::user()->role === 'admin') {
                return view('Admin.dashboard', compact(
                    'totalStudents',
                    'totalTeachers',
                    'totalResults',
                    'chartLabels',
                    'chartData',
                    'passCount',
                    'failCount',
                    'tasks',
                    'topStudents'
                ));
            } elseif(Auth::user()->role === 'teacher'){
                $teacher = Teacher::where('teacher_email', Auth::user()->email)->first();
                if (!$teacher) {
                    return back()->with('error', 'Teacher not found.');
                }

                // Counts
                $totalGrades = DB::table('grades')->where('gradeId', $teacher->grade)->count();
                $totalStudents = DB::table('teachers as t')
                    ->join('students as s', 't.grade', '=', 's.gradeId')
                    ->where('t.teacher_email', $teacher->teacher_email)
                    ->count();

                    // dd($totalStudents);
                // FIXED: use correct column subject_id
                $totalExam = DB::table('exams')
                    ->where('subject_id', $teacher->teacher_subject)
                    ->count();

                // Classes with student counts
                $classes = DB::table('grades as g')
                    ->select('g.gradeId', 'g.gradeId as name',
                        DB::raw('(SELECT COUNT(*) FROM students WHERE students.gradeId = g.gradeId) as students_count'))
                    ->where('g.gradeId', $teacher->grade)
                    ->get();

                $subject = Subject::get()->first();

                $cards = [
                    ['title' => 'Total Classes', 'value' => $totalGrades, 'icon' => 'fa-chalkboard', 'color' => '#4e73df'],
                    ['title' => 'Total Students', 'value' => $totalStudents, 'icon' => 'fa-user-graduate', 'color' => '#1cc88a'],
                    ['title' => 'Total Exams', 'value' => $totalExam, 'icon' => 'fa-file-alt', 'color' => '#f6c23e'],
                ];

                $performanceLabels = ['Class A', 'Class B', 'Class C'];
                $performanceData = [75, 80, 90];

                return view('Teacher.dashboard', compact(
                    'cards', 'classes', 'performanceLabels', 'performanceData', 'teacher', 'totalGrades', 'totalStudents', 'totalExam', 'subject', 'topStudents'

                ));
                return view('Teacher.dashboard');
            }else{
                // if (Auth::check() && Auth::user()->role === 'user') {
                //     $data['subjects'] = Subject::all();
                //     $data['students'] = Student::with('results.subject') // eager load results and related subject
                //         ->where('email', Auth::user()->email)
                //         ->get();

                //     return view('User.dashboard', $data);
                // }

                return view('welcome');
            }

        // return view('Admin.dashboard', compact(
        //     'totalStudents',
        //     'totalTeachers',
        //     'totalResults',
        //     'chartLabels',
        //     'chartData',
        //     'passCount',
        //     'failCount',
        //     'tasks',
        //     'topStudents'
        // ));
    }

    /**
     * Show the application dashboard.
     */
    // Dashboard for admin
    public function adminDashboard()
    {
        return view('Admin.dashboard'); // resources/views/admin/dashboard.blade.php
    }

    // Dashboard for teacher
    public function teacherDashboard()
    {

        return view('Teacher.dashboard'); // resources/views/teacher/dashboard.blade.php
    }

    // Dashboard for user
    public function userDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            $userEmail = Auth::user()->email;

            $student = DB::table('students as s')
                ->where('s.email', '=', $userEmail)
                ->first();
                // var_dump($student);

            if (!$student) {
                return view('User.dashboard', [
                    'student' => null,
                    'results' => [],
                    'attendances' => []
                ]);
            }

            // Get results with exam and subject
            $results = DB::table('results as r')
            ->join('exams as e', 'e.id', '=', 'r.exam_id')
            ->join('subjects as sub', 'sub.id', '=', 'e.subject_id')
            ->where('r.student_id', $student->id)
            ->select(
                'r.*',
                'e.*',
                'sub.*'  // change here based on actual column
            )
            ->get();
            // var_dump($results);

            // Get attendance records
            $attendances = DB::table('attendances as a')
                ->join('rollcalls as r', 'r.attendanceTypeId', '=', 'a.attendanceTypeId')
                ->where('studentId', $student->studentId)
                ->get();
            // var_dump($attendances);
            // dd($attendances);


            return view('User.dashboard', [
                'student' => $student,
                'results' => $results,
                'attendances' => $attendances
            ]);
        }

        return view('welcome');
    }


    // Common home page after login
    public function home()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('user.dashboard');
        // }

        // $role = Auth::user()->role;

        // if ($role === 'admin') {
        //     return redirect()->route('admin.dashboard');
        // } elseif ($role === 'teacher') {
        //     return redirect()->route('teacher.dashboard');
        // } elseif ($role === 'user') {
        //     return redirect()->route('user.dashboard');
        // }

        // return redirect()->route('home');
        return view('welcome'); // resources/views/home.blade.php
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
