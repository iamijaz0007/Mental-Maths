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
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('worksheet_id')->constrained('worksheets')->onDelete('cascade');
            $table->integer('total_sections')->default(0); // Total sections in the worksheet
            $table->integer('completed_sections')->default(0); // Sections completed by the student
            $table->integer('total_worksheets')->default(0); // Total worksheets assigned
            $table->integer('completed_worksheets')->default(0); // Worksheets completed
            $table->integer('correct_questions')->default(0); // Correct answers
            $table->integer('incorrect_questions')->default(0); // Incorrect answers
            $table->integer('time_spent_on_sections')->default(0); // Time spent on each section
            $table->integer('total_time_spent_on_worksheets')->default(0); // Total time spent on all worksheets
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};
