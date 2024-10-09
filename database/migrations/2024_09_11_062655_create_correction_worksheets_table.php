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
        Schema::create('correction_worksheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_worksheet_id')->constrained('worksheets');  // Original worksheet ID
            $table->foreignId('student_id')->constrained('users');  // Student doing the correction
            $table->boolean('is_corrected')->default(false);  // Whether the student corrected the errors
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correction_worksheets');
    }
};
