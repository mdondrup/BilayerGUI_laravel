<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class ExperimentsOP extends Experiments
{
    protected $table = 'experiments';

    protected static function booted(): void
    {
        static::addGlobalScope('type', fn(Builder $q) => $q->where('type', 'OP'));
        static::creating(fn($model) => $model->type = 'OP');
    }

    public function getForeignKey()
    {
        return 'trajectory_id';
    }

    public function trajectories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Trayectoria::class,
            'trajectories_experiments_OP',
            'experiment_id',
            'trajectory_id'
        );
    }

    public function getHydration()
    {
        return $this->properties()->where('name', 'TOTAL_HYDRATION')->first();
    }

    public function displayName()
    {
        $hydration = $this->getHydration();
        if ($hydration) {
            return parent::displayName() . ' (Hydr.: ' . $hydration->value . '%)';
        }   
        return parent::displayName();
    }   
}
