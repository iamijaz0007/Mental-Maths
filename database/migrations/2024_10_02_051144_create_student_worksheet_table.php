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
        Schema::create('student_worksheet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worksheet_id')->constrained()->onDelete('cascade');  // Link to the worksheet
            $table->foreignId('user_id')->constrained()->onDelete('cascade');       // Link to the student (user)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_worksheet');
    }
};
