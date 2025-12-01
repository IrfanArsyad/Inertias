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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('modules')->onDelete('cascade');
            $table->foreignId('module_groups_id')->nullable()->constrained('module_groups')->onDelete('set null');
            $table->string('permission')->nullable();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('label');
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('badge_source')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('external')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
