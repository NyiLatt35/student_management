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
        $subjectName = $request->input('subject_name');
        $moduleName = $request->input('module_name');

        $data['subjects'] = Subject::with('modules')
            ->when($subjectName, function ($queryBuilder) use ($subjectName) {
                $queryBuilder->where('sub_name', 'like', '%' . $subjectName . '%');
            })
            ->when($moduleName, function ($queryBuilder) use ($moduleName) {
                $queryBuilder->whereHas('modules', function ($getModule) use ($moduleName) {
                    $getModule->where('module_code', 'like', '%' . $moduleName . '%');
                });
            })
            ->paginate(3);

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

        // Get the subject
        $subject = Subject::findOrFail($id);

        // Get the update data
        $data = $this->getSubjectData($request);

        // Update the subject
        $updateSuccess = $subject->update($data);

        if ($updateSuccess) {
            // Handle module update/creation
            $modules = Module::where('subject_id', $id)->get();

            if ($modules->count() > 0) {
                // Update existing modules
                foreach ($modules as $module) {
                    $module->update([
                        'module_name' => strtoupper(substr($data['sub_name'], 0, 3)) . $module->module_code,
                    ]);
                }
            }

            // Handle module deletions
            $deleteModules = $request->input('delete_modules', []);
            if (!empty($deleteModules)) {
                Module::whereIn('id', $deleteModules)->delete();
            }

            // Handle existing modules updates
            $modules = $request->input('lesson_code', []);

            if (!empty($modules) && is_array($modules)) {
                foreach ($modules as $moduleId => $moduleName) {
                    if (!empty($moduleName) && is_numeric($moduleId)) {
                        // Create a mock request fdor the getLessons method
                        $moduleRequest = new Request([
                            'subject_id' => $id,
                            'lesson_name' => $moduleName
                        ]);

                        // dd($moduleRequest->all());
                        $existingModule = Module::find($moduleId);
                        $moduleData = $this->getLessons($moduleRequest, true, $existingModule);

                        $exists = Module::where('subject_id', $id)
                                ->where('module_code', $moduleData['module_code'])
                                ->where('id', '!=', $moduleId)
                                ->exists();

                            if (!$exists) {
                                Module::where('id', $moduleId)->update($moduleData);
                            }

                    }
                }
            }

            // Handle new modules
            $newModules = $request->input('new_lesson_code', []);
            if (!empty($newModules) && is_array($newModules)) {
                foreach ($newModules as $moduleName) {
                    if (!empty($moduleName)) {
                        $moduleRequest = new Request([
                            'subject_id' => $id,
                            'lesson_name' => $moduleName
                        ]);

                        $moduleData = $this->getLessons($moduleRequest, false, null);

                        if ($moduleData) {
                            // ✅ Check Duplicate Module Code
                            $exists = Module::where('subject_id', $id)
                                ->where('module_code', $moduleData['module_code'])
                                ->exists();
                            // If the module does not exist, create it
                            if ($exists) {
                                // error message
                                return redirect()->back()->with('error', 'Module already exists!');
                            }else {
                            Module::create($moduleData);
                            }
                        }
                    }
                }
            }

        }
        // Redirect with success message
        return redirect()->route('subject.index')->with('success', 'Subject updated successfully!');
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
     * Show the form for creating a new resource.
     */
    public function show(string $id)
    {
        // Fix: Get the subject with its modules
        $subject = Subject::with('modules')->find($id);

        // Check if subject exists
        if (!$subject) {
            return redirect()->route('subject.index')->with('error', 'Subject not found!');
        }

        $data['subject'] = $subject;

        return view('Pages.subject.detail', $data);
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
        $data = [
            'sub_name' => $request->input('subject_name'),
        ];

        // Only add module_code if it exists in the request
        if ($request->has('module_code')) {
            $data['module_code'] = $request->input('module_code');
        }

        return $data;
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

        $moduleCount = Module::where('subject_id', $request->subject_id)->count();
        $moduleCount++;
        $module_code = strtoupper(substr($subject->sub_name, 0, 3)) . $request->lesson_name;

        return [
            'subject_id' => $request->subject_id,
            'module_code' => $request->lesson_name,
            'module_name' => $module_code,
        ];
    }
}
