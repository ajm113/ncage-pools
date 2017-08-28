<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrackerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_users', function (Blueprint $table) {
            $table->integer('id')->unique();
        });

        Schema::create('tracker_activity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('posted');
            $table->string('path');
            $table->bigInteger('ip_id');
            $table->integer('event_id');
        });

        Schema::create('tracker_event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('tracker_ips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_users');
        Schema::dropIfExists('tracker_activity');
        Schema::dropIfExists('tracker_event_types');
        Schema::dropIfExists('tracker_ips');
    }
}
