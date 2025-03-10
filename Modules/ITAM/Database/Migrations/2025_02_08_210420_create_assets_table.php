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
        Schema::create('itam_assets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('ownership_type')->default('owned'); // owned, leased, partner
            $table->uuid('partner_id')->nullable()->constrained('itam_partners');
            $table->string('asset_tag')->unique();
            $table->string('name');
            $table->uuid('category_id')->constrained('itam_asset_categories');
            $table->uuid('type_id')->constrained('itam_asset_types');
            $table->uuid('manufacturer_id')->nullable()->constrained('itam_manufacturers');
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->dateTime('warranty_end_date')->nullable();
            $table->string('status')->default('active'); // active, inactive, loaned, dll.
            $table->uuid('location_id')->nullable()->constrained('itam_locations');
            $table->uuid('assigned_to')->nullable()->constrained('itam_users');
            $table->uuid('department_id')->nullable()->constrained('itam_departments');
            $table->text('notes')->nullable();
            $table->json('specifications')->nullable();
            
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');


            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('asset_tag');
            $table->index('name');
            $table->index('type_id');
            $table->index('category_id');
            $table->index('manufacturer_id');
            $table->index('status');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itam_assets');
    }
};
