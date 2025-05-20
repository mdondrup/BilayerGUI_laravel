<?php

namespace App;

use App\Lib\Coleccion;
use Illuminate\Database\Eloquent\Model;

class AppModel extends Model
{
    static public function getTableName() {
        $self = new static();
        return $self->table;
    }

    public function newCollection(array $models = Array())
    {
        return new Coleccion($models);
    }
}
