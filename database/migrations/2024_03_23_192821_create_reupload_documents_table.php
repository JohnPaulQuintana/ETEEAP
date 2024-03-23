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
        Schema::create('reupload_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checking_document_id');
            $table->foreign('checking_document_id')->references('id')->on('checking_documents')->onDelete('cascade');

            $table->text('reupload_description')->nullable();
            $table->text('path');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reupload_documents');
    }
};
