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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('total_amount', 10, 2);
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->enum('status', ['pending','order place','complete'])->default('pending'); // e.g., pending, completed
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
