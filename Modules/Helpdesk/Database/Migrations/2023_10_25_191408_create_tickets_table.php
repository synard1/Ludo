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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            // $table->uuid('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->datetime('response_time')->nullable();
            $table->datetime('resolution_time')->nullable();
            $table->datetime('report_time');
            $table->string('reporter_name')->nullable();     // Nama pelapor
            $table->string('origin_unit')->nullable();       // Unit kerja asal
            $table->json('issue_category')->nullable();
            $table->string('priority')->nullable();          // Prioritas
            $table->string('status')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('work_order_notes', 'ifExists');
        // Schema::dropIfExists('work_order_responses', 'ifExists');
        // Schema::dropIfExists('work_orders', 'ifExists');
        // Schema::dropIfExists('tickets', 'ifExists');
        Schema::disableForeignKeyConstraints(); // Disable foreign key checks
        Schema::dropIfExists('tickets'); // Drop the table
        Schema::enableForeignKeyConstraints(); // Enable foreign key checks back
    }
};
