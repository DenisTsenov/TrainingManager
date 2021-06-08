<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();

            $table->unique('name');
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unique(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
}
