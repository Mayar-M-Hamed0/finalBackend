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
        Schema::create('service_center_cars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_center_id');
            $table->unsignedBigInteger('car_id');
            $table->timestamps();



            
            $table->foreign('service_center_id')->references('id')->on('service_centers')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_center_cars');
    }
};
