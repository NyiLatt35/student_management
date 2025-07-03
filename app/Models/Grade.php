<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $primaryKey = 'gradeId'; // Specify primary key
    protected $fillable = ['gradeId', 'gradeName'];

    public function grade()
{
    return $this->belongsTo(Grade::class, 'gradeId', 'gradeId');
}
}

