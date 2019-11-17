<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('consumer')->nullable();
            $table->unsignedInteger('cable_id');
            $table->string('automate_name')->nullable();
            $table->enum('automate_category',['C','D','B','None']);
            $table->integer('automate_nominal')->default(10);
            $table->boolean('enter')->default(false);
            $table->boolean('pred')->default(false);
            $table->boolean('diff')->default(false);
            $table->boolean('uzo')->default(false);
            $table->unsignedInteger('shield_id');
            $table->integer('order');
            $table->boolean('numerable')->default(true);
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
        Schema::dropIfExists('groups');
    }
}
