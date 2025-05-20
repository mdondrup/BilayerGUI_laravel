<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agua extends AppModel
{
    protected $table = 'water_models';

    public function getForeignKey() {
        return 'water_id';
    }
}