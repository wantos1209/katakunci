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
        Schema::create('newssearch_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('newssearch_id')->unsigned();
            $table->string('title');
            $table->string('link');
            $table->string('snippet');
            $table->date('date');
            $table->string('source');
            $table->string('imageUrl');
            $table->integer('position');
            $table->timestamps();
            $table->index('newssearch_id');
            $table->foreign('newssearch_id')->references('id')->on('newssearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newssearch_detail');
    }
};
