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

    // This method is used to get the display name of the model, which can be used in views or other parts of the application.
    public function displayName()
    {
        return  ($this->short_name ?? $this->name ?? 'ID: ' . $this->id ?? 'Unknown');
    }   

    public function displayTitle()
    {
        return $this?->title ?? "An object: " . $this::class . " " . $this->displayName();

    }

}