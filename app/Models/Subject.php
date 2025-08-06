<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['sub_name'];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function getSubjects()
    {
        $subjects = DB::table('teachers as t')
            ->join('grades as g', 'g.gradeId', '=', 't.grade')
            ->join('students as st', 'st.gradeID', '=', 'g.gradeId')
            ->join('subjects as s', 't.teacher_subject', '=', 's.id')
            ->whereColumn('t.grade', 'st.gradeID')
            ->select('s.*')
            ->get();

        return response()->json($subjects);
    }
}