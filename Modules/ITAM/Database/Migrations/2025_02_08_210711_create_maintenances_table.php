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
        Schema::create('itam_maintenances', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('asset_id')->constrained('itam_assets');
            $table->uuid('task_id')->constrained('itam_maintenance_tasks');
            $table->date('performed_at');
            $table->uuid('performed_by')->nullable()->constrained('itam_technicians');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->json('details')->nullable(); // For any task-specific details
            
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
        Schema::dropIfExists('itam_maintenances');
    }
};
