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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentId')->unique();

            // Link to the users table
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // <-- NEW & IMPORTANT

            $table->string('studentName', 60);
            $table->string('photo')->nullable(); // <-- NEW: For the student's photo path
            $table->date('dateOfBirth')->nullable();
            $table->string('gender', 10)->nullable(); // <-- NEW
            $table->unsignedBigInteger('gradeId');
            $table->date('enrollmentDate')->nullable(); // <-- NEW
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('parentName')->nullable(); // <-- NEW
            $table->string('parentPhone', 50)->nullable(); // <-- NEW
            $table->timestamps();

            // Foreign key constraint for gradeId
            $table->foreign('gradeId')->references('gradeId')->on('grades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};