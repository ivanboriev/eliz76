<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('temp')->nullable();
            $table->string('atm')->nullable();
            $table->string('humidity')->nullable();
            $table->boolean('isolate')->default(false);
            $table->boolean('phase')->default(false);
            $table->boolean('uzo')->default(false);
            $table->boolean('automate')->default(false);
            $table->string('engineer1')->nullable();
            $table->string('engineer2')->nullable();
            $table->string('documents_path')->nullable();
            $table->boolean('documents_generated')->default(false);
            $table->unsignedInteger('customer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
