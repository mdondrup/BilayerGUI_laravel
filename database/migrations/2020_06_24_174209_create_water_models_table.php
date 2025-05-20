<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_models', function (Blueprint $table) {
            $table->id();
            $table->text('short_name');
            $table->text('full_name');
            $table->string('resolution');
            $table->boolean('polarizable');
            $table->integer('number_particles');
            $table->float('dipolar_moment');
            $table->text('itpfile');
            $table->text('reference');
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
        Schema::dropIfExists('water_models');
    }
}
