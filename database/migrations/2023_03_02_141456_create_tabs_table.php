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
        Schema::create('tabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id');
            $table->foreignId('parent_id')->default(0);
            $table->boolean('droppable')->default(true);
            $table->integer('order')->nullable();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->boolean('has_child')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabs');
    }
};
