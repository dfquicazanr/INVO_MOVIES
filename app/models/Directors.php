<?php

use Phalcon\Mvc\Model;

/**
 * Created by PhpStorm.
 * User: Dany1
 * Date: 20/09/2018
 * Time: 8:48 PM
 */

class Directors extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    public function initialize() {
        $this->hasMany(
            'id',
            'Movies',
            'directors_id', [
                'foreignKey' => [
                    'message' => 'Director cannot be deleted because it\'s used in Movies'
                ]
        ]);
    }
}