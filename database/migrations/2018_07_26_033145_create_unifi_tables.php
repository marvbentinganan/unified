<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnifiTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::create('access_logs', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('user_id');
        //     $table->macAddress('device');
        //     $table->ipAddress('ip');
        //     $table->timestamp('expires_on');
        //     $table->longtext('url');
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Schema::dropIfExists('access_logs');
    }
}
