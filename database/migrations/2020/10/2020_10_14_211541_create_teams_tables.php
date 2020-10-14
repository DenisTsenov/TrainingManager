<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trainer_id');
            $table->date('created_at');

            $table->foreign('trainer_id')->references('id')->on('users');
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('competitor_id');
            $table->date('joined_at');
            $table->date('left_at');

            $table->index(['team_id', 'competitor_id']);

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('competitor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
    }
}
