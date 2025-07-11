<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

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
        return view('Pages.teacher.create', $data);
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

    // Validation of teacher data
    public function validateTeacherData(Request $request)
    {
        return $request->validate([
            'teacher_name' => 'required|string|max:255',
            'teacher_email' => 'required|email|max:255|unique:teachers,teacher_email',
            'teacher_phone' => 'required|string|max:15',
            'teacher_subject' => 'required|string|max:255',
            'subject_code' => 'required|string|max:10',
        ]);
    }

    // get Teahcer Data
    public function getTeacherData(Request $request)
    {
        return [
            'teacher_name' => $request->name,
            'teacher_email' => $request->email,
            'teacher_phone' => $request->phone,
            'teacher_subject' => $request->subject_name,
            'subject_code' => $request->subject_code,

        ];
    }
}
