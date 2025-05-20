<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampoDeFuerza extends Model
{
    protected $table = 'forcefields';
    
    public function getForeignKey() {
        return 'forcefield_id';
    }
}
