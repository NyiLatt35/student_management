<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;


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
    public static function getStudentAttendanceRecord()
    {
        $return = Rollcall::select('rollcalls.*', 'grades.gradeName as gradeName', 'students.studentName as studentName')
            ->join('grades', 'rollcalls.gradeId', '=', 'grades.gradeId')
            ->join('students', 'rollcalls.studentId', '=', 'students.studentId');
            // ->join('users as createdBy', 'rollcalls.createdBy', '=', 'users.id');
            if(!empty(Request::get('grade'))){
                $return = $return->where('rollcalls.gradeId', '=', request()->get('grade'));
            }
            if(!empty(Request::get('attendance_date'))){
                $return = $return->whereDate('rollcalls.attendanceDate', '=', Request::get('attendance_date'));
            }
            if(!empty(Request::get('attendance_type'))){
                $return = $return->where('rollcalls.attendanceTypeId', '=', Request::get('attendance_type'));
            }
            if(!empty(Request::get('student_name'))){
                $return = $return->where('students.studentName', 'like', '%'.Request::get('student_name').'%');
            }

        $return = $return->orderBy('rollcalls.attendanceDate', 'desc')
                    ->paginate(5);
        return $return;
    }
}
