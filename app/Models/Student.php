<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;
use App\Models\Rollcall;


class Student extends Model
{
    protected $fillable = [ 'studentId', 'studentName', 'dateOfBirth', 'gradeId', 'phone', 'email', 'address'];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'gradeId', 'gradeId');
    }

    public static function getAttendance($studentId, $gradeId, $attendanceDate)
    {
        // return Rollcall::checkAlreadyAttendance($studentId, $gradeId, $attendanceDate);
        return Rollcall::where('studentId', '=', $studentId)
            ->where('gradeId', '=', $gradeId)
            ->whereDate('attendanceDate', '=', $attendanceDate)
            ->first();
    }
}
