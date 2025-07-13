<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->id();
            $table->string('studentId');
            $table->unsignedBigInteger('attendanceTypeId');
            $table->unsignedBigInteger('gradeId'); // Match grades table type
            $table->date('attendanceDate');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('studentId')->references('studentId')->on('students')->onDelete('cascade');
            $table->foreign('gradeId')->references('gradeId')->on('grades')->onDelete('cascade');
            $table->foreign('attendanceTypeId')->references('attendanceTypeId')->on('attendances')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rollcalls');
    }
};