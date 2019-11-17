<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParamsToSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->json('isolate_equip')->nullable();
            $table->json('phase_equip')->nullable();
            $table->json('uzo_equip')->nullable();
            $table->json('automate_equip')->nullable();
            $table->json('contur_equip')->nullable();
            $table->json('teplovizor_equip')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->string('contur_temp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn([
                'isolate_equip',
                'phase_equip',
                'uzo_equip',
                'automate_equip',
                'contur_equip',
                'teplovizor_equip',
                'min',
                'max',
                'contur_temp'
            ]);

        });
    }
}
