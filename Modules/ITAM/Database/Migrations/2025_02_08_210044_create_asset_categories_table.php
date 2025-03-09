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
        Schema::create('itam_asset_categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('prefix')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');

            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itam_asset_categories');
    }
};
