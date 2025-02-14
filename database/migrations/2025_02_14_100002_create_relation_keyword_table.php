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
        Schema::create('relation_keyword', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('keyword_id')->unsigned();
            $table->bigInteger('related_id')->unsigned(); //Bisa merujuk ke id di tabel mapsearch, websearch, videosearch dll
            $table->integer('jenis'); //  1 = websearch, 2 = videosearch, 3 = newssearch, 4 = mapsearch, 5 = imagesearch
            $table->timestamps();
            $table->index('keyword_id');
            $table->index('related_id');
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
        Schema::dropIfExists('websearch');
    }
};
