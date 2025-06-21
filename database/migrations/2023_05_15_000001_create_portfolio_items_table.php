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
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable(); // Array of image paths
            $table->string('category')->nullable();
            $table->string('client')->nullable();
            $table->date('completion_date')->nullable();
            $table->string('project_url')->nullable();
            $table->json('technologies')->nullable(); // Array of technologies used
            $table->boolean('is_featured')->default(false);
            $table->integer('order')->default(0);
            $table->json('meta_data')->nullable(); // For SEO and other metadata
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};
