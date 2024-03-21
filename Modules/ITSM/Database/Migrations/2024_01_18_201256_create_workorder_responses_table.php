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
        Schema::create('itsm_workorder_responses', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('workorder_id');
            $table->longText('description')->nullable();
            $table->string('module');
            $table->string('status');
            $table->boolean('publish')->default('1');
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->string('notes')->nullable();
            
            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('workorder_id')->references('id')->on('itsm_work_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itsm_workorder_responses');
    }
};
