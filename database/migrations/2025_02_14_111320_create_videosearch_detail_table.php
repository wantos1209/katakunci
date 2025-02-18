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
        Schema::create('videosearch_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('videosearch_id')->unsigned();
            $table->string('title');
            $table->string('link');
            $table->string('snippet');
            $table->string('imageUrl');
            $table->time('duration')->nullable();
            $table->string('source');
            $table->string('channel');
            $table->date('date');
            $table->integer('position');
            $table->timestamps();
            $table->index('videosearch_id');
            $table->foreign('videosearch_id')->references('id')->on('videosearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videosearch_detail');
    }
};
