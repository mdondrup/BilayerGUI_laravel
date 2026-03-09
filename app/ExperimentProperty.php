<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/****
 * Class ExperimentProperty
 * @property string name
 * @property string value
 * @property string unit
 * @package App
 */ 

class ExperimentProperty extends AppModel{
    protected $table = 'experiment_property';

    public function getForeignKey() {
        return 'experiment_id';
    }

    public function displayTitle()
    {
        return "Experiment Property: " . $this->name;
    }

    public function displayName()
    {
        return $this->name . ': ' . $this->value . ' ' . $this->unit;
    }
}