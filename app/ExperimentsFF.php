<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class ExperimentsFF extends Experiments
{
    protected $table = 'experiments';

    protected static function booted(): void
    {
        static::addGlobalScope('type', fn(Builder $q) => $q->where('type', 'FF'));
        static::creating(fn($model) => $model->type = 'FF');
    }

    public function getForeignKey()
    {
        return 'trajectory_id';
    }

    public function trajectories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Trayectoria::class,
            'trajectories_experiments_FF',
            'experiment_id',
            'trajectory_id'
        );
    }

    public function getSampleType()
    {
        $xray_json = $this->properties()->where('name', 'XRAY')->first();
        if ($xray_json) {
            $xray_data = json_decode($xray_json->value, true);
            return $xray_data['SAMPLE_TYPE'] ?? '';
        }
        return '';
    }

    public function displayName()
    {
        $st = $this->getSampleType();
        return parent::displayName() . ($st ? ' (' . $st . ')' : '');
    }
}
