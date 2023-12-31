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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->float('total_sale');
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->boolean('status')->default(true)->nullable();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
