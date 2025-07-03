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
        Schema::create('results', function (Blueprint $table) {
            $table->string('studentId');
            $table->enum('result', ['passed', 'failed']);
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
        Schema::dropIfExists('results');
    }
};
