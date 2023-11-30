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
        Schema::create('work_order_responses', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('work_order_id');
            $table->foreign('work_order_id')->references('id')->on('work_orders');
            $table->integer('no');
            $table->longText('no_workorder');
            $table->longText('no_workorder_custom')->nullable();
            $table->longText('work_order_subject');
            $table->longText('work_order_description');
            $table->longText('supervisor')->nullable();
            $table->longText('staff')->nullable();
            $table->longText('user')->nullable();
            $table->longText('response')->nullable();
            $table->string('status')->nullable();
            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->longText('ticket_payload');
            $table->longText('workorder_payload');
            $table->longText('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_responses');
    }
};
