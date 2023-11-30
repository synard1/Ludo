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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->uuid('ticket_id')->after('id');
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->string('origin_unit')->nullable()->after('user');
            $table->string('priority')->after('status');
            $table->longText('ticket_details')->before('deleted_at');
            $table->longText('work_order_response')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // $table->dropColumn(['tickets_id','origin_unit']);
        });
    }
};
