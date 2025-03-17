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
        Schema::create('itam_upgrades', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('asset_id')->constrained('itam_assets');
            $table->date('upgrade_date');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->uuid('performed_by_id')->nullable()->constrained('itam_users');
            $table->string('performed_by_name');
            
            $table->string('user_cid');
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
        Schema::dropIfExists('itam_upgrades');
    }
};
