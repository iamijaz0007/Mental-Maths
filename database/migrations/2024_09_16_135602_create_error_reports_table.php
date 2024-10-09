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
        Schema::create('error_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Add this column
            $table->unsignedBigInteger('worksheet_id');
            $table->text('error_message');
            $table->enum('status', ['pending', 'resolved', 'not_an_error'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamps();
        
            // Foreign key references
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('worksheet_id')->references('id')->on('worksheets')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_reports');
    }
};
