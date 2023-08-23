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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('item_quantity');
            $table->float('price');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('item_category_id');
            $table->timestamp('expiration_date')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('item_category_id')->references('id')->on('item_categories')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
