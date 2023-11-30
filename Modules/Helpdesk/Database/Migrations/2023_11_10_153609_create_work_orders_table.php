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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('no');
            $table->longText('no_workorder');
            $table->longText('no_workorder_custom')->nullable();
            $table->longText('supervisor')->nullable();
            $table->longText('staff')->nullable();
            $table->longText('user')->nullable();
            $table->longText('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('status');
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();

            $table->longText('supervisor_sign')->nullable();
            $table->longText('staff_sign')->nullable();
            $table->longText('user_sign')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
