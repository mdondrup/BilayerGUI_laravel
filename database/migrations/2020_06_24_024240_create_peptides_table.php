<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeptidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peptides', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_charge');
            $table->integer('length');
            $table->float('electrostatic_dipolar_moment');
            $table->float('edm_longitudinal');
            $table->float('edm_transversal');
            $table->float('hydrophobic_dipolar_moment');
            $table->float('hdm_longitudinal');
            $table->float('hdm_transversal');
            $table->string('type');
            // Natural / Designed
            $table->string('sequence');
            $table->text('reference');
            $table->string('url');

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
        Schema::dropIfExists('peptides');
    }
}
