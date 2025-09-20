<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id'); // Customer
            $table->uuid('store_id'); // Store owner
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->integer('total_coins_used');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed'])->default('pending');
            $table->enum('payment_status', ['pending', 'completed'])->default('pending');
            
            // Delivery address (temporary for this order)
            $table->string('delivery_name');
            $table->string('delivery_email');
            $table->string('delivery_phone')->nullable();
            $table->text('delivery_address');
            $table->string('delivery_city');
            $table->string('delivery_state');
            $table->string('delivery_country');
            $table->string('delivery_postal_code')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->index(['user_id', 'status']);
            $table->index(['store_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_orders');
    }
};