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
        Schema::create('service_center_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_center_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('service_center_id')->references('id')->on('service_centers')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_center_services');
    }
};
