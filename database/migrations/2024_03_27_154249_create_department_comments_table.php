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
        Schema::create('department_comments', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('forward_to_depts_id');
            $table->foreign('forward_to_depts_id')->references('id')->on('forward_to_depts')->onDelete('cascade');

            $table->text('document_name')->nullable();
            $table->text('department_comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_comments');
    }
};
