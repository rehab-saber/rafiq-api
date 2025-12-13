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
        Schema::create('lovas_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['game', 'visual_task', 'language_task', 'other'])->default('game');
            $table->integer('level')->default(1);
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->string('asset_url')->nullable();
            $table->timestamps();

            $table->foreign('skill_id')->references('id')->on('lovas_skills')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lovas_activities');
    }
};
