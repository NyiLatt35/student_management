<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique();
            $table->string('teacher_name');
            $table->string('teacher_email')->unique();
            $table->string('teacher_phone')->nullable();
            $table->string('teacher_address')->nullable();
            $table->unsignedBigInteger('teacher_subject')->nullable(); // Changed to unsignedBigInteger
            $table->unsignedBigInteger('grade')->nullable(); // Changed to unsignedBigInteger
            $table->string('teacher_password')->nullable();
            $table->timestamps();

            // Fixed foreign keys
            $table->foreign('teacher_subject')
                ->references('id')
                ->on('subjects')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('grade')
                ->references('gradeId') // This matches grades table
                ->on('grades')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};