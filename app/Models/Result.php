<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'student_id',
        'exam_id',
        'marks_obtained',
        'total_marks',
        'grade_id',
        'subject_id',
        'status',
    ];
    public function student() { return $this->belongsTo(Student::class, 'student_id'); }
    public function exam() { return $this->belongsTo(Exam::class, 'exam_id'); }
    // public function grade() { return $this->belongsTo('App\Models\Grade', 'grade_id'); }
   public function teacher() { return $this->belongsTo(Teacher::class, 'id'); }
   public function subject() { return $this->belongsTo(Subject::class, 'subject_id'); }

   

}
