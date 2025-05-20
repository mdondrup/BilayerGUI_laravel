<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Molecula extends AppModel
{
    protected $table = 'heteromolecules';

    public function getForeignKey() {
        return 'molecule_id';
    }
}
