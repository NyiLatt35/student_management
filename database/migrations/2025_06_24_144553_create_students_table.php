<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentId')->unique();
            $table->string('studentName', 60);
            $table->date('dateOfBirth')->nullable();
            $table->unsignedBigInteger('gradeId'); // Changed to unsignedBigInteger
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->timestamps();

            // Add foreign key
            $table->foreign('gradeId')->references('gradeId')->on('grades')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};