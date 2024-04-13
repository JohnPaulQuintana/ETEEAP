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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('reciever_id')->default(1);
            $table->foreign('reciever_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('course_id');
            $table->string('educational_attainment');
            
            $table->string('loi')->nullable();
            $table->string('ce')->nullable();
            $table->string('cr')->nullable();
            $table->string('nce')->nullable();
            $table->string('hdt')->nullable();
            $table->string('f137_8')->nullable();
            $table->string('abcb')->nullable();
            $table->string('mc')->nullable();
            $table->string('nbc')->nullable();
            $table->string('ge')->nullable();
            $table->string('pc')->nullable();
            $table->string('rl')->nullable();
            $table->string('cgmc')->nullable();
            $table->string('cer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
