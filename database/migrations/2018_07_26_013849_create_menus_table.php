<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('link')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('has_children')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->unsignedInteger('menu_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menu_role', function (Blueprint $table) {
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('role_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
