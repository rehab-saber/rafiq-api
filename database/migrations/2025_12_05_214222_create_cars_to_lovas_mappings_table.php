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
        Schema::create('cars_to_lovas_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cars_question_id');
            $table->unsignedBigInteger('lovas_activity_id');
            $table->string('severity_level')->nullable(); // optional: e.g. mild/moderate/severe or score threshold
            $table->timestamps();

            $table->foreign('cars_question_id')->references('id')->on('cars_questions')->onDelete('cascade');
            $table->foreign('lovas_activity_id')->references('id')->on('lovas_activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars_to_lovas_mappings');
    }
};
