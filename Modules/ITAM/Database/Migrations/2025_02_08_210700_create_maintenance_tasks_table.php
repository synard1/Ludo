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
        Schema::create('itam_maintenance_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('task_category')->nullable();
            $table->string('task_name')->nullable();
            $table->string('task_description')->nullable();
            $table->string('frequency')->nullable(); // weekly, monthly, yearly, once
            
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
        Schema::dropIfExists('itam_maintenance_tasks');
    }
};
