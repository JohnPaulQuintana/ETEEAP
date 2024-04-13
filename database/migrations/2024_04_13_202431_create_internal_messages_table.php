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
        Schema::create('internal_messages', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sender_id');
            $table->text('message');
            $table->text('action_required')->nullable();
            $table->text('message_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_messages');
    }
};
