<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id');
            $table->uuid('client_id');
            $table->uuid('ads_id');
            $table->uuid('site_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('ads_clients')->onDelete('cascade');
            $table->foreign('ads_id')->references('id')->on('ads')->onDelete('cascade');
            $table->foreign('site_id')->references('id')->on('ads_sites')->onDelete('cascade');
            $table->string('ads_time')->nullable();
            $table->string('days')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads_schedules');
    }
};
