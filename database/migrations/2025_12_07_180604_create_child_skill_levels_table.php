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
        Schema::create('child_skill_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('skill_id');
            $table->integer('score')->default(0);
            $table->integer('current_level')->default(1);
            $table->timestamps();

            $table->unique(['child_id', 'skill_id']);
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('lovas_skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_skill_levels');
    }
};
