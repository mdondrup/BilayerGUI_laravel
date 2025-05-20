<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajectoriesLipidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajectories_lipids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trajectory_id');
            $table->foreign('trajectory_id')->references('id')->on('trajectories');
            $table->unsignedBigInteger('lipid_id');
            $table->foreign('lipid_id')->references('id')->on('lipids');
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
        Schema::dropIfExists('trajectories_lipids');
    }
}
