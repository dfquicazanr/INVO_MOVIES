<?php

use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
/**
 * Created by PhpStorm.
 * User: Dany1
 * Date: 21/09/2018
 * Time: 12:07 AM
 */

class MoviesForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }

        $name = new Text("name");
        $name->setLabel("Name");
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'Name is required'
            ])
        ]);
        $this->add($name);

        $director = new Select('directors_id', Directors::find(), [
            'using'      => ['id', 'name'],
            'useEmpty'   => false
        ]);
        $director->setLabel('Director');
        $this->add($director);

        $actors = new Select('actors_id', Actors::find(), [
            'using'      => ['id', 'name'],
            'useEmpty'   => false,
            'multiple'   => true
        ]);
        $actors->setDefault(array());
        $actors->setLabel('Actors');
        $this->add($actors);
    }
}