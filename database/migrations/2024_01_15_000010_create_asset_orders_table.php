<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_orders', function (Blueprint $table) {
            // UUID as primary key
            $table->uuid('id')->primary()->default(Str::uuid());
            
            // Hashid column for public-facing identifiers
            $table->string('hashid')->nullable()->unique()->comment('Public-facing hashed identifier');
            
            // Foreign keys
            $table->uuid('user_id')->comment('Buyer');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->uuid('asset_id');
            $table->foreign('asset_id')->references('id')->on('digital_assets')->onDelete('restrict');
            
            // Order Type
            $table->enum('order_type', ['purchase', 'rental']);
            
            // Pricing at time of order
            $table->decimal('amount_paid', 10, 2);
            $table->integer('coins_used')->default(0);
            $table->decimal('platform_share', 10, 2)->comment('Platform cut');
            $table->decimal('user_share', 10, 2)->comment('Asset owner cut');
            $table->boolean('system_managed_at_purchase')->comment('Was asset system managed when purchased');
            
            // Rental specific fields
            $table->enum('rental_period', ['daily', 'weekly', 'monthly', 'yearly'])->nullable();
            $table->integer('rental_duration')->nullable()->comment('Number of periods');
            $table->timestamp('rental_starts_at')->nullable();
            $table->timestamp('rental_expires_at')->nullable();
            
            // Purchase specific fields
            $table->enum('purchase_type', ['source', 'hosting', 'enterprise', 'whitelabel'])->nullable();
            
            // Order Status
            $table->enum('status', ['pending', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('asset_id');
            $table->index('order_type');
            $table->index('status');
            $table->index('rental_expires_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_orders');
    }
};