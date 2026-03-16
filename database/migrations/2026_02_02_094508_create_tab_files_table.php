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
        Schema::create('tab_files', function (Blueprint $table) {
           $table->id();

    $table->unsignedBigInteger('tab_id');

    // File / Table category
    $table->enum('category', ['file', 'table'])->default('file');

    $table->string('title');
    $table->string('file_path')->nullable();

    $table->integer('sort_order')->default(0);
    $table->boolean('status')->default(true);

    $table->timestamps();

    $table->foreign('tab_id')
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
        Schema::dropIfExists('tab_files');
    }
};
