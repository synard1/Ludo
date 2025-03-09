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
        Schema::create('itam_asset_trackings', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('asset_id')->constrained('itam_assets');
            $table->string('change_type'); // Penugasan, Pengembalian, Pemeliharaan, Upgrade, dll.
            $table->uuid('changed_by')->constrained('itam_technicians');
            $table->timestamp('change_date')->useCurrent();
            $table->text('description')->nullable();
            $table->uuid('performed_by_id')->nullable()->constrained('itam_technicians');
            $table->string('performed_by_name');
            
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
        Schema::dropIfExists('itam_asset_trackings');
    }
};
