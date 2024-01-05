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
        Schema::create('helpdesk_service_management', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->datetime('response_time')->nullable();
            $table->datetime('resolution_time')->nullable();

            $table->datetime('report_time');
            $table->string('report_source');
            $table->string('report_name')->nullable();     // Nama pelapor
            $table->string('report_unit')->nullable();       // Unit kerja asal
            
            $table->json('category')->nullable();
            $table->string('priority')->nullable();          // Prioritas
            $table->boolean('count_kpi')->default(true);
            $table->string('status')->nullable();

            $table->string('work_order_id')->nullable();
            $table->longText('work_order')->nullable();

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
        Schema::dropIfExists('service_management');
    }
};
