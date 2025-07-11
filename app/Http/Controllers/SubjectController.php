<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Module;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $data['subjects'] = Subject::with('modules')->when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('sub_name', 'like', '%' . $query . '%')
                 ->orWhereHas('modules', function ($getModule) use ($query) {
                     $getModule->where('module_code', 'like', '%' . $query . '%');
                 });
        })->paginate(3);

        return view('Pages.subject.subjects', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateSubjectName($request);

        $existingSubject = Subject::where('sub_name', $request->input('subject_name'))->first();

        if ($existingSubject) {
            return redirect()->back()->with('error', 'Subject already exists!');
        }

        $data = $this->getSubjectData($request);
        Subject::create($data);

        return redirect()->back()->with('success', 'Subject created successfully!');
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validateSubjectNameForUpdate($request, $id);

        $subject = Subject::findOrFail($id);
        $oldSubjectName = $subject->sub_name;

        // Update subject name
        $subject->update(['sub_name' => $request->input('subject_name')]);

        // If subject name changed, update all module codes and if replaced or prefix first 3 characters
        if ($oldSubjectName !== $subject->sub_name) {
            $newPrefix = strtoupper(substr($subject->sub_name, 0, 3));
            $modules = Module::where('subject_id', $id)->get();

            foreach ($modules as $module) {
                // Update module code with new prefix
                $module->update(['module_code' => $newPrefix . substr($module->module_code, 3)]);
            }
        }

        // Handle module deletions
        $deleteModules = $request->input('delete_modules', []);
        if (!empty($deleteModules)) {
            Module::whereIn('id', $deleteModules)->delete();
        }

        // Handle module updates and new modules
        $lessonCodes = $request->input('lesson_code', []);

        if (!empty($lessonCodes) && is_array($lessonCodes)) {
            // Get existing modules for this subject
            $existingModules = Module::where('subject_id', $id)->get();
            $existingModuleIndex = 0;

            foreach ($lessonCodes as $moduleCode) {
                if (!empty($moduleCode)) {
                    // Generate proper module code
                    $fullModuleCode = strtoupper(substr($subject->sub_name, 0, 3)) . $moduleCode;

                    // Check if this is updating an existing module or creating new one
                    if ($existingModuleIndex < $existingModules->count()) {
                        // Update existing module
                        $existingModule = $existingModules[$existingModuleIndex];
                        $existingModule->update(['module_code' => $fullModuleCode]);
                        $existingModuleIndex++;
                    } else {
                        // Create new module
                        Module::create([
                            'subject_id' => $id,
                            'module_code' => $fullModuleCode
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.subject.index')->with('success', 'Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subject::destroy($id);
        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }

    /**
     * Validate the subject name for creation.
     */
    private function validateSubjectName(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,sub_name',
        ], [
            'subject_name.unique' => 'Subject already exists!',
            'subject_name.required' => 'Subject name is required!',
        ]);
    }

    /**
     * Validate subject name for update.
     */
    private function validateSubjectNameForUpdate(Request $request, string $id)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255|unique:subjects,sub_name,' . $id,
        ], [
            'subject_name.unique' => 'Subject already exists!',
            'subject_name.required' => 'Subject name is required!',
        ]);
    }

    /**
     * Get subject data from request.
     */
    public function getSubjectData(Request $request)
    {
        return [
            'sub_name' => $request->input('subject_name'),
        ];
    }

    /**
     * Generate module code from subject and module names.
     */
    public function getLessons(Request $request, $isUpdate = false, $exitingModule = null)
    {
        $subject = Subject::find($request->subject_id);

        if (!$subject) {
            return null;
        }

        if (!$isUpdate) {
            $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_code;
            
            // Check if module code already exists
            if (Module::where('module_code', $module_code)->exists()) {
            return null; // Return null if duplicate exists
            }
        } else {
            if ($exitingModule && $subject->id != $exitingModule->subject_id) {
            $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_code;
            
            // Check if module code already exists and is not the current module
            if (Module::where('module_code', $module_code)->where('id', '!=', $exitingModule->id)->exists()) {
                return null; // Return null if duplicate exists
            }
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