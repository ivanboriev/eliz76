<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('group_name')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->json('isolate_data')->nullable();
            $table->boolean('isolate_block')->default(false);
            $table->json('phase_data')->nullable();
            $table->boolean('phase_block')->default(false);
            $table->json('uzo_data')->nullable();
            $table->boolean('uzo_block')->default(false);
            $table->json('automate_data')->nullable();
            $table->boolean('automate_block')->default(false);
            $table->unsignedInteger('cluster_id');
            $table->integer('order');
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
        Schema::dropIfExists('shields');
    }
}
