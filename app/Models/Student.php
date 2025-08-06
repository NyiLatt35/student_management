<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Grade;
use App\Models\Rollcall;


class Student extends Model
{
    // protected $fillable = [ 'user_id', 'studentId', 'studentName', 'dateOfBirth', 'gradeId', 'phone', 'email', 'address'];
    protected $fillable = [
        'user_id',
        'studentId',
        'studentName',
        'dateOfBirth',
        'gender',
        'gradeId',
        'enrollmentDate',
        'photo',
        'phone',
        'email',
        'address',
        'parentName',
        'parentPhone',
    ];
    public function getRouteKeyName()
    {
        return 'studentId';
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'gradeId', 'gradeId');
    }
    public function results()
    {
        return $this->hasMany(Result::class, 'student_id');
    }
    public function exams(){
        return $this->hasMany(Exam::class, 'studentId', 'studentId');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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
