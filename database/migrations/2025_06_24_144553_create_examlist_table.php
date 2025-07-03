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
        Schema::create('examlist', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('examId')->nullable(); // optional exam code
            $table->string('examName', 100)->unique();
            $table->string('studentId');
            $table->unsignedBigInteger('gradeId');
            $table->timestamps();

            $table->foreign('studentId')->references('studentId')->on('students');
            $table->foreign('gradeId')->references('gradeId')->on('grades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examlist');
    }
};
