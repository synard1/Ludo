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
        Schema::create('work_order_notes', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('ticket_id');
            $table->uuid('work_order_id');
            $table->uuid('work_order_response_id')->nullable();
            $table->longText('response')->nullable();
            $table->json('issue_category')->nullable();
            $table->string('status')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');
            
            $table->foreign('work_order_response_id')->references('id')->on('work_order_responses');
            $table->foreign('work_order_id')->references('id')->on('work_orders');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('work_order_notes');
        Schema::disableForeignKeyConstraints(); // Disable foreign key checks
        Schema::dropIfExists('work_order_notes'); // Drop the table
        Schema::enableForeignKeyConstraints(); // Enable foreign key checks back
    }
};
