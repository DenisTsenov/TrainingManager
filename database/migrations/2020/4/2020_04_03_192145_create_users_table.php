<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin')->default(0);
            $table->foreignId('sport_id')->constrained();
            $table->foreignId('settlement_id')->constrained();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('full_name')->virtualAs("CONCAT_WS(' ', first_name, last_name)");
            $table->timestamps();
            $table->softDeletes();

            $table->unique('full_name');
        });

        Schema::table('settlements', function(Blueprint $table){
            $table->foreignId('created_by')->after('name')->constrained('users');
        });

        Schema::table('sports', function(Blueprint $table){
            $table->foreignId('created_by')->after('name')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
