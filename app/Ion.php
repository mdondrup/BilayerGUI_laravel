<?php

namespace App;

class Ion extends AppModel
{
    protected $table = 'ions';

    public function getForeignKey()
    {
        return 'ion_id';
    }

    public function displayName()
    {
        return $this->molecule ?? $this->short_name ?? $this->name ?? 'Unknown Ion '.$this->id;
    }

    public function displayTitle()
    {
        return "Ion: " . ($this?->name ?? $this->displayName());
    }   
}
