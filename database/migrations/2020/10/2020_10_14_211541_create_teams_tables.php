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
            $table->string('name', 250);
            $table->foreignId('trainer_id')->constrained('users');
            $table->foreignId('sport_id')->constrained('sports');
            $table->foreignId('settlement_id')->constrained('settlements');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('competitor_id')->constrained('users');
            $table->date('joined_at');
            $table->date('left_at');

            $table->unique(['team_id', 'competitor_id']);
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
