<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('matchId');
            $table->string('team1');
            $table->string('team2');
            $table->integer('team1id');
            $table->integer('team2id');
            $table->string('time');
            $table->string('mode');
            $table->string('result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match');
    }
}
