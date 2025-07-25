<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_name',
        'exam_date',
        'exam_time',
        'duration',
        'total_marks',
        'passing_marks',
        'subject_id',
        'grade_id',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'exam_time' => 'datetime:H:i',
    ];

    /**
     * Get the grade that owns the exam.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id', 'gradeId');
    }

    /**
     * Get the subject that owns the exam.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}