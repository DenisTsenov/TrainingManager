<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementSportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlement_sport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained();
            $table->foreignId('sport_id')->constrained();

            $table->unique(['settlement_id', 'sport_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settlement_sport');
    }
}
