<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Lipido
 * @property string short_name
 * @package App
 */
class Lipido extends AppModel
{
    protected $table = 'lipids';

    public function getForeignKey()
    {
        return 'lipid_id';
    }


}
