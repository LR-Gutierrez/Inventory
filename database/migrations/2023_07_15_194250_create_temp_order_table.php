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
        Schema::create('temp_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('item_quantity');
            $table->float('price');
            $table->timestamps();
            $table->unsignedBigInteger('created_by');

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_order');
    }
};
