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
        Schema::create('shortcut_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shortcut_id')->unsigned();
            $table->string('name');
            $table->string('url');
            $table->timestamps();
            $table->index('shortcut_id');
            $table->foreign('shortcut_id')->references('id')->on('shortcut')
            ->onDelete('restrict') 
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortcut_detail');
    }
};
