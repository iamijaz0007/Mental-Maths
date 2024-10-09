<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('section_progress', function (Blueprint $table) {
            $table->decimal('time_taken', 8, 2)->nullable()->after('completed'); // Add the time_taken column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('section_progress', function (Blueprint $table) {
            $table->dropColumn('time_taken'); // Drop the time_taken column if the migration is rolled back
        });
    }
};
