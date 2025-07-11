<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'teacher_name',
        'teacher_email',
        'teacher_phone',
        'teacher_subject',
        'subject_code',
    ];
}
