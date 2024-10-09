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
        Schema::table('users', function (Blueprint $table) {
            // Adding the parent_id column
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');

            // Setting up the foreign key constraint
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dropping the foreign key constraint and the column
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
