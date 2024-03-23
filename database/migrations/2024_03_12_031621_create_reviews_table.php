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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string(column:'Description');
            $table->integer(column:'rate');
            $table->unsignedBigInteger('user_id');
           
            $table->unsignedBigInteger('service_center_id');
            $table->timestamps();



            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_center_id')->references('id')->on('service_centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};








