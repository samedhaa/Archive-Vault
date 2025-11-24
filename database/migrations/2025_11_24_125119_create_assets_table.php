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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('archive_item_id')
                ->constrained()
                ->onDelete('cascade');

            // File storage info
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('mime_type')->nullable();
            $table->string('extension', 10)->nullable();

            // Size
            $table->unsignedBigInteger('size_bytes')->nullable();

            // Timestamp
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();

            // Used for filtering by format
            $table->index('extension');
            $table->index('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
