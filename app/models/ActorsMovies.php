<?php

use Phalcon\Mvc\Model;

/**
 * Created by PhpStorm.
 * User: Dany1
 * Date: 21/09/2018
 * Time: 12:10 AM
 */

class ActorsMovies extends Model
{
    public function initialize() {
        $this->belongsTo(
            'actors_id',
            'actors',
            'id'
        );
        $this->belongsTo(
            'movies_id',
            'movies',
            'id'
        );
    }
}