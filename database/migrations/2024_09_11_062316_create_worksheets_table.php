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
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Name of the worksheet
            $table->foreignId('created_by')->constrained('users');  // Admin who created the worksheet
            
            // Define the user_id column before adding the foreign key constraint
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Student the worksheet is assigned to
            
            $table->enum('status', ['incomplete', 'complete', 'paused'])->default('incomplete');  // Status of the worksheet
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worksheets');
    }
};
