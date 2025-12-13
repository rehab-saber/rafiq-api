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
        Schema::create('cars_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('option_id');
            $table->integer('score')->nullable(); // score from option (denormalized for fast queries)
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('cars_questions')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('cars_question_options')->onDelete('cascade');
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('cars_answers');
    }
};
