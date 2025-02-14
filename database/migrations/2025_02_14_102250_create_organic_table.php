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
        Schema::create('organic', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('websearch_id')->unsigned();
            $table->string('title');
            $table->string('link');
            $table->string('snippet');
            $table->string('iconUrl');
            $table->integer('position');
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
        Schema::dropIfExists('organic');
    }
};
