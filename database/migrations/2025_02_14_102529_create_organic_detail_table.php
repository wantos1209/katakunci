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
        Schema::create('organic_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('organic_id')->unsigned();
            $table->string('title');
            $table->string('link');
            $table->timestamps();
            $table->index('organic_id');
            $table->foreign('organic_id')->references('id')->on('organic')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organic_detail');
    }
};
