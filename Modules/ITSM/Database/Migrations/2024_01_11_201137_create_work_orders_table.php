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
        Schema::create('itsm_work_orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->integer('number');
            $table->string('workorder_number');
            $table->string('workorder_number_custom')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('staff')->nullable();
            $table->string('location')->nullable();
            $table->string('user')->nullable();
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->string('module');
            $table->string('status');
            $table->string('priority');
            $table->uuid('sla_id')->nullable();
            $table->string('sla_name')->nullable();
            $table->uuid('data_id')->nullable();
            $table->json('data_details')->nullable();
            $table->datetime('due_date')->nullable();
            $table->datetime('report_time')->nullable();
            $table->datetime('response_time')->nullable();
            $table->datetime('resolved_time')->nullable();
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();

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
        Schema::dropIfExists('itsm_work_orders');
    }
};
