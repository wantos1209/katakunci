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
        Schema::create('mapsearch_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mapsearch_id')->unsigned();
            $table->string('title');
            $table->string('address');
            $table->string('latitude')->default(null);
            $table->string('longitude')->default(null);
            $table->decimal('rating')->default(0);
            $table->decimal('ratingCount')->default(0);
            $table->string('category');
            $table->string('phoneNumber');
            $table->string('website');
            $table->integer('position');
            $table->timestamps();
            $table->index('mapsearch_id');
            $table->foreign('mapsearch_id')->references('id')->on('mapsearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapsearch_detail');
    }
};
