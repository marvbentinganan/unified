<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigihubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('digihubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->ipAddress('ip')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('usage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('digihub_id');
            $table->foreign('digihub_id')->references('id')->on('digihubs')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usage');
        Schema::dropIfExists('digihubs');
    }
}
