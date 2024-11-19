<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clouds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alt')->nullable();
            $table->string('image');
            $table->string('image_thumb');
            $table->string('type');
            $table->string('size')->default('0');
            $table->string('orientation');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clouds');
    }
};
