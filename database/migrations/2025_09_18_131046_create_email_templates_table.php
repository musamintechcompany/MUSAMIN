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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('subject');
            $table->longText('header')->nullable();
            $table->longText('body');
            $table->longText('footer')->nullable();
            $table->string('header_image')->nullable();
            $table->string('footer_image')->nullable();
            $table->json('body_images')->nullable();
            $table->enum('type', ['welcome', 'verification', 'password_reset', 'notification', 'affiliate', 'general']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
