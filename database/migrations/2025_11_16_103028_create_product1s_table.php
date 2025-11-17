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
        Schema::create('product1s', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price');
            $table->json('metadata')->nullable();
            $table->date('released_at')->nullable();
            $table->text('secret_notes')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product1s');
    }
};
