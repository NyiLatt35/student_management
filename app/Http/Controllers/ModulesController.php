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
        // dd($request->all());
        // Validate the request data
        $data['data'] = $this->validate($request, [
            'subject_id' => 'required|exists:subjects,id',
            'lesson_name' => 'required|string|max:255',
        ]);

        // Get the lesson_name contain unique name
        $data['modules'] = $this->getLessons($request);

        // Check if the lesson already exists for the subject
        // $existingModule = Module::where('subject_id', $data['modules']['subject_id'])
        //     ->where('module_code', $data['modules']['module_code'])
        //     ->first();

        // // If the lesson already exists, return an error message
        // if ($existingModule) {
        //     return redirect()->back()->with('error', 'Lesson already exists for this subject!');
        // }

        // // Check if the module code already exists
        // $existingModuleCode = Module::where('module_code', $data['modules']['module_code'])->first();
        // if ($existingModuleCode) {
        //     return redirect()->back()->with('error', 'Lesson with this code already exists!');
        // }
        // Get the subject to access sub_name
        // $subject = Subject::find($data['modules']['subject_id']);

        // // unique module code generation
        // $moduleCount = Module::where('subject_id', $data['modules']['subject_id'])->count();
        // $moduleCount++;
        // $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_name;

        // Prepare the data for creating the lesson

        $data['modules'] = $this->getLessons($request);
        // Check if module name already exists for this subject
        $existingModuleName = Module::where('subject_id', $data['modules']['subject_id'])
            ->where('module_name', $data['modules']['module_name'])
            ->first();
        if ($existingModuleName) {
            return redirect()->back()->with('error', 'Lesson already exists for this subject!');
        }

        // Prepare the data for creating the lesson
        $data['modules'] = $this->getLessons($request);

        // Create the new lesson
        // dd($data['modules']);
        Module::create($data['modules']);
        return redirect()->route('admin.lesson.index')->with('success', 'Lesson created successfully.');

    }











        // // Validate the lesson data
        // $this->validate($request, [
        //     'subject_id' => 'required|exists:subjects,id',
        //     'lesson_name' => 'required|string|max:255',
        // ]);

        // // Check if the lesson already exists
        // $existingModule = Module::where('subject_id', $request->subject_id)
        //     ->where('module_code', 'like', '%' . $request->lesson_name . '%')
        //     ->first();

        // if ($existingModule) {
        //     return redirect()->back()->with('error', 'Lesson already exists for this subject!');
        // }

        // // Get the lesson data
        // $data = $this->getLessons($request);

        // if (!$data) {
        //     return redirect()->back()->with('error', 'Invalid subject selected!');
        // }

        // // Check if the module code already exists
        // $existingModuleCode = Module::where('module_code', $data['module_code'])->first();

        // if ($existingModuleCode) {
        //     return redirect()->back()->with('error', 'Lesson with this code already exists!');
        // }

        // // Create the new lesson
        // Module::create($data);

        // return redirect()->route('admin.lesson.index')->with('success', 'Lesson created successfully.');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $data['subject'] = Subject::findOrFail($id);
        // $data['modules'] = Module::all();
        // return view('Pages.subject.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(string $id)
    // {
    //    // check if the model_name is already exists
    //     $request = request();
    //     // dd($request->all());
    //     // check if module_name is already exists
    //     $this->validate($request, [
    //         'subject_id' => 'required|exists:subjects,id',
    //         'lesson_name' => 'required|string|max:255',
    //     ]);

    //     $data['modules'] = Module::where('id', $id)->first();
    //     if (!$data['modules']) {
    //         return redirect()->back()->with('error', 'Lesson not found!');
    //     }
    //     if($data['modules']->module_name == $request->lesson_name) {
    //         return redirect()->back()->with('error', 'Lesson name is already exists!');
    //     }
    //     // Get the lesson data
    //     $data = $this->getLessons($request);
    //     dd($data);

    //     Module::update($data);
    //     return redirect()->route('admin.lesson.index')->with('success', 'Lesson updated successfully.');

    //     }

        /**
         * Update the specified resource in storage.
         */
    //     public function update(string $id)
    //     {
    //         $request = request();

    //         // Validate the request
    //         $this->validate($request, [
    //             'subject_id' => 'required|exists:subjects,id',
    //             'lesson_name' => 'required|string|max:255',
    //         ]);

    //         // Find the existing module
    //         $existingModule = Module::findOrFail($id);

    //         // Get the new lesson data
    //         $newData = $this->getLessons($request);

    //         // Check if subject has changed or lesson name has changed
    //         $subjectChanged = $existingModule->subject_id != $request->subject_id;
    //         $lessonNameChanged = $existingModule->module_code != $request->lesson_name;

    //         // If the new module_name is the same as old module_name, don't update
    //         if ($newData['module_name'] == $existingModule->module_name && !$subjectChanged) {
    //             return redirect()->back()->with('error', 'No changes detected!');
    //         }

    //         // Check if module with same name already exists for this subject (excluding current module)
    //         $duplicateModule = Module::where('subject_id', $request->subject_id)
    //             ->where('module_name', $newData['module_name'])
    //             ->where('id', '!=', $id)
    //             ->first();

    //         if ($duplicateModule) {
    //             return redirect()->back()->with('error', 'Lesson with this name already exists for this subject!');
    //         }

    //         // Update the module
    //         dd($newData);
    //         $existingModule->update($newData);

    //         return redirect()->route('admin.lesson.index')->with('success', 'Lesson updated successfully.');
    // }

    /**
     * Get lessons data
     */
    public function getLessons(Request $request)
    {
        // $subject = Subject::find($request->subject_id);

        // if (!$subject) {
        //     return null;
        // }

        // if (!$isUpdate) {
        //     // Creating new lesson
        //     $moduleCount = Module::where('subject_id', $subject->id)->count();
        //     $moduleCount++;

        //     $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
        //           str_pad($moduleCount, 3, '0', STR_PAD_LEFT);

        //     // Ensure unique module code
        //     while (Module::where('module_code', $module_code)->exists()) {
        //     $moduleCount++;
        //     $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
        //               str_pad($moduleCount, 3, '0', STR_PAD_LEFT);
        //     }
        // } else {
        //     // Updating existing lesson
        //     if ($exitingModule && $subject->id != $exitingModule->subject_id) {
        //     $moduleCount = Module::where('subject_id', $subject->id)->count();
        //     $moduleCount++;

        //     $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
        //               str_pad($moduleCount, 3, '0', STR_PAD_LEFT);

        //     while (Module::where('module_code', $module_code)->exists() &&
        //           $module_code !== $exitingModule->module_code) {
        //         $moduleCount++;
        //         $module_code = strtoupper(substr($subject->sub_name, 0, 3)) .
        //               str_pad($moduleCount, 3, '0', STR_PAD_LEFT);
        //     }
        //     } else {
        //     $module_code = $exitingModule->module_code;
        //     }
        // }

         // unique module code generation
        $subject = Subject::find($request->subject_id);

        if (!$subject) {
            return null;
        }

        $moduleCount = Module::where('subject_id', $request->subject_id)->count();
        $moduleCount++;
        $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_name;
        // Ensure unique module code
        // while (Module::where('module_code', $module_code)->exists()) {
        //     $moduleCount++;
        //     $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_name;
        // }

        return [
            'subject_id' => $request->subject_id,
            'module_code' => $request->lesson_name,
            'module_name' => $module_code,
        ];
    }
}