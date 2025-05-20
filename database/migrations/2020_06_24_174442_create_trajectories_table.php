<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajectories', function (Blueprint $table) {
            $table->id();
            $table->text('composition');
            $table->integer('length');
            $table->text('mdp_json');
            $table->text('mdp_file');
            $table->text('top_file');
            $table->text('text');
            $table->text('last_pdb');
            $table->string('software_name');
            $table->string('software_version');
            $table->string('supercomputer');
            $table->text('queue_file');
            $table->float('performance');
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
        Schema::dropIfExists('trajectories');
    }
}
