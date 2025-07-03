<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rollcall extends Model
{
    protected $fillable = [
        'studentId',
        'attendanceTypeId',
        'gradeId',
        'attendanceDate'
    ];

    protected $casts = [
        'attendanceDate' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId', 'studentId');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'gradeId', 'gradeId');
    }

    public function attendanceType()
    {
        return $this->belongsTo(Attendance::class, 'attendanceTypeId', 'id');
    }

    public static function checkAlreadyAttendance($studentId, $gradeId, $attendanceDate)
    {
        return Rollcall::where('studentId', '=', $studentId)
            ->where('gradeId', '=', $gradeId)
            ->whereDate('attendanceDate', '=', $attendanceDate)
            ->first();
    }
}
