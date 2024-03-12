<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToServiceCentersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_centers', function (Blueprint $table) {
            // Add new columns
            $table->string('name');
            $table->integer('phone');
            $table->float('rating');
            $table->string('working_days');
            $table->string('working_hours');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            
            // Drop existing 'car_name' column
            $table->dropColumn('car_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_centers', function (Blueprint $table) {
            // Add back 'car_name' column
            $table->string('car_name');

            // Drop new columns
            $table->dropColumn('name');
            $table->dropColumn('phone');
            $table->dropColumn('rating');
            $table->dropColumn('working_days');
            $table->dropColumn('working_hours');
            $table->dropColumn('description');
            $table->dropColumn('image');
        });
    }
}
