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
        Schema::table('sections', function (Blueprint $table) {
            Schema::table('sections', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->after('worksheet_id')
                    ->nullable()
                    ->constrained('users')
                    ->onDelete('set null'); // Foreign key reference to users table
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['user_id']);
            // Then drop the user_id column
            $table->dropColumn('user_id');
        });
    }
};
