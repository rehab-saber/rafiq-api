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
        Schema::create('cars_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->unsignedBigInteger('lovas_skill_id')->nullable();
            $table->timestamps();

            $table->foreign('lovas_skill_id')->references('id')->on('lovas_skills')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars_questions');
    }
};
