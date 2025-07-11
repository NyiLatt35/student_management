<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'date',
        'time',
        'duration',
        'total_marks',
        'passing_marks',
        'subject_id',
    ];
}
