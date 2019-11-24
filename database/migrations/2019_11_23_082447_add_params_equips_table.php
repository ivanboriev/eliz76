<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParamsEquipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equips', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->date('next_check_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equips', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'next_check_date',
            ]);
        });
    }
}
