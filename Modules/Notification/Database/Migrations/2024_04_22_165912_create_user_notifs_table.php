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
        Schema::create('notification_users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('category_id')->nullable();
            $table->uuid('platform_id');
            $table->string('module');
            $table->string('sub_module');
            $table->string('name');
            $table->longText('description');
            $table->boolean('status')->default('1'); // 0: Not Active ; 1 : Active
            $table->json('details')->nullable();

            $table->string('user_cid');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('created_by');
            $table->string('created_by_level');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('platform_id')->references('id')->on('notification_platforms');
            $table->foreign('category_id')->references('id')->on('notification_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_users');
    }
};
