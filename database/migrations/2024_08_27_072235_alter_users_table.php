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
            $table->string('gender')->nullable()->after('password');
            $table->string('phone')->nullable()->after('gender');
            $table->string('occupation')->nullable()->after('phone');
            $table->string('profile_pic')->nullable()->after('occupation');
            $table->string('date_of_birth')->nullable()->after('profile_pic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['gender', 'phone', 'occupation', 'profile_pic', 'date_of_birth']);
        });
    }
};
