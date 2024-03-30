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
        Schema::create('itsm_reporteds', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('user')->nullable();
            $table->string('location')->nullable();
            $table->string('source')->nullable();
            $table->datetime('report_time');
            $table->datetime('response_time');
            $table->datetime('resolved_time')->nullable();
            $table->json('category')->nullable();

            $table->uuid('data_id')->nullable();
            $table->string('data_module')->nullable();
            $table->string('data_number')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itsm_reporteds');
    }
};
