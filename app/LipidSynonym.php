<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LipidSynonym extends Model
{
    protected $table = 'lipids_synonyms';

    public function getForeignKey()
    {
        return 'lipid_id';
    }

    public function lipid()
    {
        return $this->belongsTo(Lipido::class, 'lipid_id', 'id');
    }
}
