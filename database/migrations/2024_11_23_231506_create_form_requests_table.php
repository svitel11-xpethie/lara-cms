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
        Schema::create('form_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the requester
            $table->string('email'); // Email of the requester
            $table->string('phone')->nullable(); // Optional phone number
            $table->text('message'); // Main message
            $table->json('additional_inputs')->nullable(); // JSON field for dynamic data
            $table->boolean('sms_sent')->default(false); // Email sent status
            $table->boolean('email_sent')->default(false); // Email sent status
            $table->boolean('whatsapp_sent')->default(false); // WhatsApp sent status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_requests');
    }
};
