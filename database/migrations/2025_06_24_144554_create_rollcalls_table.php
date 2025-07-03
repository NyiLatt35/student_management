<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rollcalls', function (Blueprint $table) {
            $table->id();
            $table->string('studentId');
            $table->integer('attendanceTypeId')->unsigned();
            $table->string('gradeId');
            $table->date('attendanceDate');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('studentId')->references('studentId')->on('students');
            $table->foreign('gradeId')->references('gradeId')->on('grades');
            $table->foreign('attendanceTypeId')->references('attendanceTypeId')->on('attendances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rollcalls');
    }
};
