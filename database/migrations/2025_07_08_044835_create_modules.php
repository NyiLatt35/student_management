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

    Schema::create('modules', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('subject_id'); // Changed from string
    $table->string('module_code')->unique();
    $table->string('module_name')->nullable(); // Add this if using Solution 1

    $table->foreign('subject_id')
          ->references('id')
          ->on('subjects')
          ->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
