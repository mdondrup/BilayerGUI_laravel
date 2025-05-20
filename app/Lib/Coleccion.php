<?php

namespace App\Lib;

class Coleccion extends \Illuminate\Database\Eloquent\Collection
{
    function implodeLink($value, $glue = null, $href = null, $href_parametros = 'id')
    {
        if(!$this->count()) {
            return '';
        }
        $buffer = '';
        foreach ($this as $k => $elemento) {
            $buffer .= '<a href="'.route($href, $elemento->$href_parametros).'">'.$elemento->$value.'</a>';
            $buffer .= $glue.' ';
        }
        echo substr($buffer, 0, -2);
    }
}