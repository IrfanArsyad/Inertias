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
        Schema::create('module_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'User Management', 'E-Commerce', 'Settings'
            $table->string('label'); // Display name
            $table->string('icon')->nullable(); // Group icon
            $table->integer('order')->default(0); // Display order
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_groups');
    }
};
