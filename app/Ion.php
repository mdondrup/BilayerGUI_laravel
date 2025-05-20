<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ion extends AppModel
{
    protected $table = 'ions';

    public function getForeignKey() {
        return 'ion_id';
    }
}
