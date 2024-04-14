<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateSubmittedToDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Add the date_submitted column with a default value of the current timestamp
            $table->timestamp('date_submitted')->default(now())->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the date_submitted column if needed (reversing the migration)
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('date_submitted');
        });
    }
}
