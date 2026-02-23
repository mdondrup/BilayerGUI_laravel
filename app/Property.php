<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/****
 * Class LipidProperty
 * @property string name
 * @property string value
 * @property string unit
 * @package App
 */

class Property extends AppModel{
    protected $table = 'properties';

    public function getForeignKey() {
        return 'property_id';
    }
}