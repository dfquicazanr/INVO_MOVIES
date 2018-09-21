<?php

use Phalcon\Mvc\Model;

/**
 * Created by PhpStorm.
 * User: Dany1
 * Date: 20/09/2018
 * Time: 8:47 PM
 */

class Actors extends Model
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
            'ActorsMovies',
            'actors_id'
        );
        $this->hasManyToMany(
            'id',
            'ActorsMovies',
            'actors_id', 'movies_id',
            'Movies',
            'id'
        );
    }
}