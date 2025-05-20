<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajectoriesPeptidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajectories_peptides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trajectory_id');
            $table->foreign('trajectory_id')->references('id')->on('trajectories');
            $table->unsignedBigInteger('peptide_id');
            $table->foreign('peptide_id')->references('id')->on('peptides');
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
        Schema::dropIfExists('trajectories_peptides');
    }
}
