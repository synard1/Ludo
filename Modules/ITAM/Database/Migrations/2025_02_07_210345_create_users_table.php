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
        Schema::create('itam_users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('username')->nullable();
            $table->string('password'); // Pastikan di-hash saat disimpan
            $table->string('name');
            $table->string('email')->nullable();
            
            $table->string('user_cid');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itam_users');
    }
};
