<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Module;

class ModulesController extends Controller
{
    public function index()
    {
        $data['subjects'] = Subject::all();
        return view('Pages.lessons.create', $data);
    }

    public function store(Request $request)
    {
        // Validate the lesson data
        $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'lesson_name' => 'required|string|max:255',
        ]);

        // Check if the lesson already exists
        $existingModule = Module::where('subject_id', $request->subject_id)
            ->where('module_code', 'like', '%' . $request->lesson_name . '%')
            ->first();

        if ($existingModule) {
            return redirect()->back()->with('error', 'Lesson already exists for this subject!');
        }

        // Get the lesson data
        $data = $this->getLessons($request);

        if (!$data) {
            return redirect()->back()->with('error', 'Invalid subject selected!');
        }

        // Check if the module code already exists
        $existingModuleCode = Module::where('module_code', $data['module_code'])->first();

        if ($existingModuleCode) {
            return redirect()->back()->with('error', 'Lesson with this code already exists!');
        }

        // Create the new lesson
        Module::create($data);

        return redirect()->route('admin.lesson.index')->with('success', 'Lesson created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['subject'] = Subject::findOrFail($id);
        $data['modules'] = Module::all();
        return view('Pages.subject.edit', $data);
    }

    /**
     * Get lessons data
     */
    public function getLessons(Request $request, $isUpdate = false, $exitingModule = null)
    {
        $subject = Subject::find($request->subject_id);

        if (!$subject) {
            return null;
        }

        if (!$isUpdate) {
            // Creating new lesson
            $moduleCount = Module::where('subject_id', $subject->id)->count();

            do {
                $moduleCount++;
                $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
                              $request->lesson_name;
            } while (Module::where('module_code', $module_code)->exists());
        } else {
            // Updating existing lesson
            if ($exitingModule && $subject->id != $exitingModule->subject_id) {
                $moduleCount = Module::where('subject_id', $subject->id)->count();

                do {
                    $moduleCount++;
                    $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
                                  $request->lesson_name;
                } while (Module::where('module_code', $module_code)->exists() &&
                        $module_code !== $exitingModule->module_code);
            } else {
                $module_code = $exitingModule->module_code;
            }
        }

        return [
            'subject_id' => $request->subject_id,
            'module_code' => $module_code,
        ];
    }
}