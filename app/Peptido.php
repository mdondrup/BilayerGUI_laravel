<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peptido extends AppModel
{
    protected $table = 'peptides';

    public function getForeignKey() {
        return 'peptide_id';
    }
}