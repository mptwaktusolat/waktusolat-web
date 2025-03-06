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
        Schema::create('jadual_waktu_solats', function (Blueprint $table) {
            $table->id();
            $table->string('zone')->comment('jakim zone');
            $table->integer('tahun');
            $table->unsignedTinyInteger('bulan');
            $table->unsignedTinyInteger('hari');
            $table->unsignedInteger('subuh')->comment('unix seconds');
            $table->unsignedInteger('syuruk')->comment('unix seconds');
            $table->unsignedInteger('zohor')->comment('unix seconds');
            $table->unsignedInteger('asar')->comment('unix seconds');
            $table->unsignedInteger('maghrib')->comment('unix seconds');
            $table->unsignedInteger('isyak')->comment('unix seconds');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadual_waktu_solats');
    }
};
