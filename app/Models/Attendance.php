<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'attendacneTypeId',
        'attendanceType'
    ];
    public function rollcalls()
    {
        return $this->hasMany(Rollcall::class, 'attendanceTypeId');
    }
}
