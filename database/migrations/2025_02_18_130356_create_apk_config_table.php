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
        Schema::create('apk_config', function (Blueprint $table) {
            $table->id();
            $table->string('version_apk')->nullable();
            $table->string('home')->nullable();
            $table->string('download_url')->nullable();
            $table->string('livechat')->nullable();
            $table->string('linkalternatif')->nullable();
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apk_config');
    }
};
