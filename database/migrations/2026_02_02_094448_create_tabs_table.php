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

    // Hierarchy
    $table->unsignedBigInteger('parent_id')->nullable();

    // Basic info
    $table->string('name');
    $table->string('slug')->nullable()->unique();

    // Page behavior
    $table->enum('page_type', ['same_page', 'new_page'])->default('same_page');
    $table->boolean('has_hierarchy')->default(false);

    // Content
    $table->string('page_heading')->nullable();
    $table->text('page_description')->nullable();

    // SEO
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();

    // Control
    $table->integer('sort_order')->default(0);
    $table->boolean('status')->default(true);

    $table->timestamps();

    // Self reference
    $table->foreign('parent_id')
          ->references('id')
          ->on('tabs')
          ->onDelete('cascade');
        
        
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
