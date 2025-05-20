<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Lipido
 * @property string name
 * @package App
 */
class Membrana extends AppModel//Model
{
    protected $table = 'membranes';

    public function getForeignKey() {
        return 'membrane_id';
    }
}
