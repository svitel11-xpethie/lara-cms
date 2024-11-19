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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->string('tags', 555)->nullable();
            $table->string('alt')->nullable();
            $table->string('image');
            $table->string('image_thumb');
            $table->string('orientation');
            $table->integer('order')->default(0);
            $table->integer('height')->default(0);
            $table->integer('width')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeries');
    }
};
