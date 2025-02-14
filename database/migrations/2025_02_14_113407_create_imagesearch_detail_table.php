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
        Schema::create('imagesearch_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('imagesearch_id')->unsigned();
            $table->string('title');
            $table->string('imageUrl');
            $table->decimal('imageWidth');
            $table->decimal('imageHeight');
            $table->string('thumbnailUrl');
            $table->decimal('thumbnailWidth');
            $table->decimal('thumbnailHeight');
            $table->string('source');
            $table->string('domain');
            $table->string('link');
            $table->integer('position');
            $table->timestamps();
            $table->index('imagesearch_id');
            $table->foreign('imagesearch_id')->references('id')->on('imagesearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagesearch_detail');
    }
};
