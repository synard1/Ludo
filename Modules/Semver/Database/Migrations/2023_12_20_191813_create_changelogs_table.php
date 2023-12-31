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
        Schema::create('semver_changelogs', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('version_id');
            $table->foreign('version_id')->references('id')->on('semver_versions');
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->string('status');

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semver_changelogs');
    }
};
