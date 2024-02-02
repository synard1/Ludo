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
        Schema::create('itsm_services', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->string('service_number')->nullable(); // Code + Number
            $table->integer('number')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('kpi')->default('1');
            $table->string('status')->default('Open');

            $table->uuid('reported_id')->nullable();
            $table->string('work_order_id')->nullable();
            
            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->foreign('category_id')->references('id')->on('itsm_service_categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reported_id')->references('id')->on('itsm_reporteds');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itsm_services');
    }
};
