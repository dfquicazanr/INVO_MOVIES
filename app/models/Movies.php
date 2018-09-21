<?php
/**
 * Created by PhpStorm.
 * User: Dany1
 * Date: 20/09/2018
 * Time: 8:45 PM
 */

use Phalcon\Mvc\Model;

/**
 * Movies
 */
class Movies extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $directors_id;

    /**
     * @var string
     */
    public $name;

    public function initialize() {
        $this->belongsTo(
            'directors_id',
            'Directors',
            'id', [
                'reusable' => true
            ]);
        $this->hasManyToMany(
            'id',
            'ActorsMovies',
            'Actors_id', 'Movies_id',
            'Actors',
            'id'
        );
    }

    /**
     * Returns the list of the actors' names
     *
     * @return string
     */
    public function getActorsNames()
    {
        $names = '';
        $actors = $this->getActors();

        foreach ($actors as $actor) {
            $names += $actor->name + ', ';
        }

        return rtrim($names,", ");
    }
}
