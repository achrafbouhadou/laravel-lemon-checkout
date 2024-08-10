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
            $table->enum('status', ['processing', 'paid', 'failed',  'refunded', 'partial_refund'])->default('processing')->index();
            $table->decimal('total', 10, 3);
            $table->string('currency', 3)->default('USD');
            $table->string('email', 100); 
            $table->string('name', 100); 
            $table->string('whatsapp_number', 20)->nullable(); 
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
