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
        Schema::create('itam_loan_agreements', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('asset_id')->constrained('itam_assets');
            $table->uuid('partner_id')->constrained('itam_partners');
            $table->date('loan_start_date');
            $table->date('loan_end_date')->nullable();
            $table->text('loan_terms')->nullable();
            
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
        Schema::dropIfExists('itam_loan_agreements');
    }
};
