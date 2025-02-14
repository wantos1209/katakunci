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
            $table->string('title');
            $table->text('description');
            $table->string('website');
            $table->string('iconUrl');
            $table->string('logoUrl');
            $table->string('desktopImageUrl');
            $table->string('mobileImageUrl');
            $table->string('livechat');
            $table->string('whatsapp');
            $table->string('telegram');
            $table->string('line');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('twitter');
            $table->string('youtube');
            $table->string('aplikasiIos');
            $table->string('aplikasiAndroid');
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
