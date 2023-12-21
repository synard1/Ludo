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
        Schema::create('semver_versions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('major')->nullable();
            $table->integer('minor')->nullable();
            $table->integer('patch')->nullable();
            $table->datetime('release_date')->nullable();
            $table->string('subject')->nullable();
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
        Schema::dropIfExists('semver_versions');
    }
};
