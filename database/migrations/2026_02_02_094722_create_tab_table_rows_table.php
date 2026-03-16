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
        Schema::create('tab_table_rows', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tab_id');

            // Optional grouping for rows (e.g. Quarterly Results)
            $table->string('row_group')->nullable();

            // Table structure
            $table->string('column_name');
            $table->text('column_value')->nullable();

            // Control
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();

            // FK
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
        Schema::dropIfExists('tab_table_rows');
    }
};
