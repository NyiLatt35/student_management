<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
       'teacher_id',
        'teacher_name',
        'teacher_email',
        'teacher_phone',
        'teacher_address',
        'teacher_subject',
        'grade',
        'teacher_password',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'teacher_subject');
    }

    public function gradeLevel()
    {
        return $this->belongsTo(Grade::class, 'grade', 'gradeId');
    }

}
