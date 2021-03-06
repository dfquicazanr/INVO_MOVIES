<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * MoviesController
 *
 * Manage operations for invoices
 */
class MoviesController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Manage your movies');
        parent::initialize();
    }

    /**
     * Shows the index action
     */
    public function indexAction()
    {
        $this->session->conditions = null;
        $this->view->form = new MoviesForm;
    }

    /**
     * Search movies based on current criteria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Movies", $this->request->getPost());
            $this->persistent->searchParams = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = [];
        if ($this->persistent->searchParams) {
            $parameters = $this->persistent->searchParams;
        }

        $movies = Movies::find($parameters);
        if (count($movies) == 0) {
            $this->flash->notice("The search did not find any movies");

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "index",
                ]
            );
        }

        $paginator = new Paginator([
            "data"  => $movies,
            "limit" => 10,
            "page"  => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
        $this->view->movies = $movies;
    }

    /**
     * Shows the form to create a new movie
     */
    public function newAction()
    {
        $this->view->form = new MoviesForm(null, ['edit' => true]);
    }

    /**
     * Edits a movie based on its id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $movie = Movies::findFirstById($id);
            if (!$movie) {
                $this->flash->error("Movie was not found");

                return $this->dispatcher->forward(
                    [
                        "controller" => "movies",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new MoviesForm($movie, ['edit' => true]);
        }
    }

    /**
     * Creates a new movie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "index",
                ]
            );
        }

        $form = new MoviesForm;
        $movie = new Movies();

        $data = $this->request->getPost();
        if (!$form->isValid($data, $movie)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "new",
                ]
            );
        }

        if ($movie->save() == false) {
            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Movie was created successfully");

        return $this->dispatcher->forward(
            [
                "controller" => "movies",
                "action"     => "index",
            ]
        );
    }

    /**
     * Saves current movie in screen
     *
     * @param string $id
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "index",
                ]
            );
        }

        $id = $this->request->getPost("id", "int");
        $movie = Movies::findFirstById($id);
        if (!$movie) {
            $this->flash->error("Movie does not exist");

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "index",
                ]
            );
        }

        $form = new MoviesForm;

        $data = $this->request->getPost();
        if (!$form->isValid($data, $movie)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "new",
                ]
            );
        }

        if ($movie->save() == false) {
            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "new",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Movie was updated successfully");

        return $this->dispatcher->forward(
            [
                "controller" => "movies",
                "action"     => "index",
            ]
        );
    }

    /**
     * Deletes a movie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $movies = Movies::findFirstById($id);
        if (!$movies) {
            $this->flash->error("Movie was not found");

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "index",
                ]
            );
        }

        if (!$movies->delete()) {
            foreach ($movies->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "movies",
                    "action"     => "search",
                ]
            );
        }

        $this->flash->success("Movie was deleted");

        return $this->dispatcher->forward(
            [
                "controller" => "movies",
                "action"     => "index",
            ]
        );
    }
}