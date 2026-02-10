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
            
            // Sender Info
            $table->boolean('is_anonymous')->default(false);
            $table->string('sender_name')->nullable(); // Nullable if anonymous
            $table->string('sender_initial')->nullable(); // For anonymous
            $table->string('sender_contact');

            // Recipient Info
            $table->string('recipient_name');
            $table->string('recipient_class');
            $table->string('recipient_contact')->nullable();

            // Bundle & Message
            $table->string('bundle_type');
            $table->text('message_content')->nullable(); // Depends on bundle

            // Payment
            $table->integer('total_price');
            $table->string('payment_method');
            $table->string('payment_proof_path')->nullable(); 

            // Status
            $table->enum('status', ['pending', 'paid', 'completed', 'cancelled'])->default('pending');

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
