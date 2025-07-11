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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name');
            $table->string('teacher_email')->unique();
            $table->string('teacher_phone')->nullable();
            $table->string('teacher_address')->nullable();
            $table->string('teacher_subject')->nullable();

            $table->timestamps();
            $table->foreign('teacher_subject')
                ->references('id')
                ->on('subjects')
                ->onDelete('set null')
                ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
