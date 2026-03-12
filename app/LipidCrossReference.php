<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class LipidCrossReference extends Model
{
    protected $table = 'cross_references';

    public function getForeignKey()
    {
        return 'lipid_id';
     }

     public function lipid()
     {
         return $this->belongsTo(Lipido::class, 'lipid_id', 'id');
     }
}