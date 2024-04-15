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
        Schema::create('alert_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reciever_id');
            $table->unsignedBigInteger('sender_id');
            $table->longText('notification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_messages');
    }
};
