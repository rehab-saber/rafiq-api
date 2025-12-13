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
        Schema::create('lovas_activity_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('activity_id');
            $table->integer('score')->nullable();
            $table->integer('time_spent')->nullable(); // seconds
            $table->enum('status', ['in-progress', 'completed', 'failed'])->default('in-progress');
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('lovas_activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lovas_activity_progress');
    }
};
