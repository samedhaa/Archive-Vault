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
        Schema::create('archive_items', function (Blueprint $table) {
            $table->id();

            // Owner
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Core metadata
            $table->string('title');
            $table->text('description')->nullable();

            // Simple category as a string (no separate categories table in MVP)
            $table->string('category')->nullable();

            // Time metadata
            $table->dateTime('captured_at')->nullable();
            $table->dateTime('uploaded_at')->useCurrent();

            // Optional location (free-text)
            $table->string('location')->nullable();

            $table->timestamps();

            // Indexes for filtering & sorting
            $table->index('title'); // For search performance
            $table->index('captured_at'); // For year filtering
            $table->index('category'); // For category filtering
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_items');
    }
};
