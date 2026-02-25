<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experiments extends Model
{
    protected $table = 'experiments';

    public function getForeignKey()
    {
        return 'trajectory_id';
    }

    public function membraneComposition()
    {
        return $this->hasMany(MembraneComposition::class, 'experiment_id', 'id');
    }
    public function getMembraneCompositionsByLipid($lipid_id)
    {
        return $this->hasMany(MembraneComposition::class, 'experiment_id', 'id')->where('lipid_id', $lipid_id)->get();
    }

    private function getTrajectoriesOP() {
        return $this->belongsToMany(Trayectoria::class, 'trajectories_experiments_OP', 'experiment_id', 'trajectory_id');
    }
    private function getTrajectoriesFF() {
        return $this->belongsToMany(Trayectoria::class, 'trajectories_experiments_FF', 'experiment_id', 'trajectory_id');
    }
    public function getTrajectories() {
        return $this->getTrajectoriesOP()->get()->merge($this->getTrajectoriesFF()->get())->sortBy('id');
    }
}
