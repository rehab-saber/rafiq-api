<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cars_question_id');
            $table->string('label');
            $table->integer('score')->default(0);
            $table->timestamps();

            $table->foreign('cars_question_id')->references('id')->on('cars_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars_question_options');
    }
};
