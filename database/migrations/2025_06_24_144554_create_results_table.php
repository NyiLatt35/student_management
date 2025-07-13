<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('studentId');
            $table->enum('result', ['passed', 'failed']);
            $table->unsignedBigInteger('gradeId'); // This matches grades table
            $table->timestamps();

            $table->foreign('studentId')->references('studentId')->on('students')->onDelete('cascade');
            $table->foreign('gradeId')->references('gradeId')->on('grades')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};