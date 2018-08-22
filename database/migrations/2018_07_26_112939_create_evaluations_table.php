<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Set Types
        Schema::create('set_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });

        // Sets
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('set_type_id');
            $table->foreign('set_type_id')->references('id')->on('set_types')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Ratings
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('value');
            $table->integer('order')->nullable();
            $table->unsignedInteger('set_type_id');
            $table->foreign('set_type_id')->references('id')->on('set_types')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Evaluations
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->unsignedInteger('set_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('semester_id');
            $table->unsignedInteger('school_year_id');
            $table->foreign('set_id')->references('id')->on('sets')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('school_years')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Evaluation Records
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('evaluation_id');
            $table->unsignedInteger('user_id');
            $table->longtext('pros')->nullable();
            $table->longtext('cons')->nullable();
            $table->longtext('others')->nullable();
            $table->longtext('remarks')->nullable();
            $table->longtext('topic')->nullable();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('value')->nullable();
            $table->integer('order')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Criterias
        Schema::create('criterias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('value')->nullable();
            $table->integer('order')->nullable();
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('ask')->unique();
            $table->unsignedInteger('criteria_id');
            $table->foreign('criteria_id')->references('id')->on('criterias')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        // Pivot Table for Many-to-Many (Question-Set)
        Schema::create('question_set', function (Blueprint $table) {
            $table->unsignedInteger('set_id');
            $table->unsignedInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('set_id')->references('id')->on('sets')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['question_id', 'set_id']);
        });

        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('record_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('criteria_id');
            $table->integer('points')->default(1);
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('criterias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('record_id')->references('id')->on('records')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
        Schema::dropIfExists('question_set');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('criterias');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('records');
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('sets');
        Schema::dropIfExists('set_types');

    }
}
