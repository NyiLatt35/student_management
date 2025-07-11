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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->integer('duration'); // Duration in minutes
            $table->integer('total_marks');
            $table->integer('passing_marks');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->string('status')->default('scheduled'); // e.g., scheduled, completed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
