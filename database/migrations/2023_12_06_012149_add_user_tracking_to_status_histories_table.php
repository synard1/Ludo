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
        Schema::table('status_histories', function (Blueprint $table) {
            $table->string('user_cid');
            $table->string('created_by');
            $table->string('created_by_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_histories', function (Blueprint $table) {
            $table->dropColumn(['user_cid','created_by','created_by_level']);
        });
    }
};
