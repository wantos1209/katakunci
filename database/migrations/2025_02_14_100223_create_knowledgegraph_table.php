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
        Schema::create('knowledgegraph', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('websearch_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('iconUrl')->nullable();
            $table->string('logoUrl')->nullable();
            $table->string('desktopImageUrl')->nullable();
            $table->string('mobileImageUrl')->nullable();
            $table->string('livechat')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('line')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('aplikasiIos')->nullable();
            $table->string('aplikasiAndroid')->nullable();
            $table->timestamps();
            $table->index('websearch_id');
            $table->foreign('websearch_id')->references('id')->on('websearch')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledgegraph');
    }
};
