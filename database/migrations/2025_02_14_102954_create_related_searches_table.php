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
        Schema::create('related_searches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('websearch_id')->unsigned();
            $table->bigInteger('keyword_id')->unsigned();
            $table->timestamps();

            $table->index('websearch_id');
            $table->foreign('websearch_id')->references('id')->on('websearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 

            $table->index('keyword_id');
            $table->foreign('keyword_id')->references('id')->on('keywords')
            ->onDelete('restrict') 
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_searches');
    }
};
