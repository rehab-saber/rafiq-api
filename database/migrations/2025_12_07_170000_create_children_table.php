<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
       public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            
            $table->string('name');             
            $table->integer('age');             
            $table->enum('gender', ['male', 'female']); 

            
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();

            $table->string('autism_level')->nullable(); 

            $table->timestamps();

            // FK constraints
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children');
    }
};
