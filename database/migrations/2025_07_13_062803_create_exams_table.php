<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->date('exam_date');
            $table->time('exam_time');
            $table->integer('duration'); // in minutes
            $table->integer('total_marks');
            $table->integer('passing_marks');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('grade_id');
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}