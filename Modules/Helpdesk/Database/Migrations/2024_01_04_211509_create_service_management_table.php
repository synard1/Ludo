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
        Schema::rename('tickets', 'helpdesk_tickets');

        Schema::create('helpdesk_services', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            
            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');
            
            $table->timestamps();
        });

        // Schema::create('helpdesk_service_requests', function (Blueprint $table) {
        //     $table->uuid('id')->primary()->unique();
        //     $table->text('request_description')->nullable();
        //     $table->timestamp('request_date');
        //     $table->string('status')->default('Pending');

        //     $table->uuid('service_id');
        //     $table->string('service_name');
        //     $table->foreign('service_id')->references('id')->on('helpdesk_services');

        //     $table->string('requester_name');
        //     $table->string('requester_unit');
        //     $table->string('requester_cid');

        //     $table->string('user_cid');
        //     $table->unsignedBigInteger('user_id');
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->string('created_by');
        //     $table->string('created_by_level');
            
        //     $table->timestamps();
        // });

        Schema::create('helpdesk_service_tracking', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->text('notes')->nullable();
            $table->string('progress_status');

            // $table->string('service_request_id');
            // $table->foreign('service_request_id')->references('id')->on('helpdesk_service_requests');

            $table->string('helpdesk_ticket_id');
            $table->string('helpdesk_ticket_subject');
            $table->foreign('helpdesk_ticket_id')->references('id')->on('helpdesk_tickets');

            $table->unsignedBigInteger('staff_id');
            $table->string('staff_name');
            $table->string('staff_cid');
            $table->foreign('staff_id')->references('id')->on('users');

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');
            
            $table->timestamps();
        });

        Schema::create('helpdesk_performance_monitoring', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('service_id');
            $table->uuid('ticket_id');
            $table->uuid('service_tracking_id');

            $table->string('performance_metric');
            $table->float('value');
            $table->string('measurement_unit', 50);
            $table->text('notes')->nullable();
            $table->timestamp('recorded_at');

            $table->unsignedBigInteger('staff_id');
            $table->string('staff_name');
            $table->string('staff_cid');
            $table->foreign('staff_id')->references('id')->on('users');

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('helpdesk_services')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('helpdesk_tickets')->onDelete('cascade');
            $table->foreign('service_tracking_id')->references('id')->on('helpdesk_service_tracking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('helpdesk_tickets', 'tickets');
        Schema::dropIfExists('helpdesk_performance_monitoring');
        Schema::dropIfExists('helpdesk_service_tracking');
        Schema::dropIfExists('helpdesk_service_requests');
        Schema::dropIfExists('helpdesk_services');

    }
};
