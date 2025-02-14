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
        Schema::create('shortcut', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('knowledgegraph_id')->unsigned();
            $table->string('name');
            $table->timestamps();
            $table->index('knowledgegraph_id');
            $table->foreign('knowledgegraph_id')->references('id')->on('knowledgegraph')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortcut');
    }
};
