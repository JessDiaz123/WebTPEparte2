<?php

require_once 'app/models/MovieModel.php';
require_once 'app/api/ApiView.php';

class MovieApiController
{
    private $model;
    private $view;
    private $data;

    function __construct()
    {
        $this->model = new MovieModel;
        $this->view = new ApiView;
        $this->data = file_get_contents("php://input"); //
    }

    //Transformo el texto RAW en json
    private function getData()
    {
        return json_decode($this->data);
    }

    //por el router que tenemos, recibimos lo del POST mediante un 
    // arreglo asociativo. (al que accedemos con $params['elParametro'])

    function getAll()
    {
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $this->getAllSorted($_GET['sort'], $_GET['order']);
        } else {
            $movies = $this->model->showAll();
            $this->view->response($movies, 200);
        }

    }

    function getAllSorted($column, $asc)
    {
        $columns = ["movieName", "movieLength", "director", "genre"];
        $order = ["asc", "desc"];
        if (in_array($column, $columns) && in_array($asc, $order)) {
            $movies = $this->model->getAllSorted($column, $asc);
            $this->view->response($movies, 200);
        } else {
            $this->view->response("bad request", 400);
        }
    }



    function getReviewsForOneMovie($params = null)
    {
        $id =  $params[':ID'];
        if (is_Numeric($id)) {
            if (isset($_GET['limit']) && isset($_GET['page'])) {
                if (is_numeric($_GET['limit']) && is_numeric($_GET['page']) && $_GET['limit'] > 0 && $_GET['page'] > 0) {
                    $limit = $_GET['limit'];
                    $page = $_GET['page'];
                } else {
                    $this->view->response("bad request, ingrese numeros correctos", 400);
                    return;
                }
            } else {
                $limit = 10;
                $page = 1;
            }
            $from = ($page-1)*$limit;
            $reviews = $this->model->getReviewsForOneMovie($id, $from, $limit);
            if ($reviews) {
                $this->view->response($reviews);
            } else {
                $this->view->response("reviews not found", 404);
            }
        } else {
            $this->view->response("bad request, id debe ser un numero", 400);
        }
    }

    function getOneReview($params = null)
    {
        $id =  $params[':ID'];
        if (($id)&&(is_numeric($id))) {
            $idRES =  $params[':IDRESEÑA'];
            $review = $this->model->getOneReview($idRES);
            if ($review) {
                $this->view->response($review);
            } else {
                $this->view->response("review doesn't found", 404);
            }
        } else {
            $this->view->response("bad request", 400);
        }
    }


    function getOne($params = null)
    {
        $id = $params[':ID'];
        $movie = $this->model->getOneItem($id);
        if ($movie) {
            $this->view->response($movie);
        } else {
            $this->view->response("Movie id=$id not found", 404);
        }
    }

    function verifyReview($params = null)
    {
        $this->verifyMovie($params);
        $idRES = $params[':IDRESEÑA'];
        if (is_numeric($idRES)) {
            $review = $this->model->getOneReview($idRES);
            if ($review) {
                return $review;
            } else {
                $this->view->response("review not found", 404);
                die();
            }
        } else {
            $this->view->response("enter a valid id for the review ", 400);
        }
    }


    function verifyMovie($params = null)
    {
        $id = $params[':ID'];
        if ($id) {
            $movie = $this->model->getOneItem($id);
            return $movie;
        } else {
            $this->view->response("movie not found", 404);
            die();
        }
    }

    function addReview($params = null)
    {
        $movie = $this->verifyMovie($params);
        if ($movie) {
            $data = $this->getData(); // transformo el text a json 
            $review = $data->review;
            $user = $data->user;
            $id = $this->model->addReview($movie->id_movie, $review, $user);
            if ($id)
                $this->view->response("the review was created successfully", 201);
            else
                $this->view->response("Review was not created", 500);
        }
    }
    function modifyReview($params = null)
    {
        $review = $this->verifyReview($params);
        $data = $this->getData();
        $newText = $data->review;
        $reviewModified = $this->model->modifyReview($review->id_review, $newText);
        if ($reviewModified)
            $this->view->response("The review was modified successfully", 200);
        else
            $this->view->response(" The review was not modified", 500);
    }

    function removeReview($params = null)
    {
        $review = $this->verifyReview($params);
        if ($review) {
            $result = $this->model->deleteOneReview($review->id_review);
            if ($result)
                $this->view->response("review id=$review->id_review was deleted successfully");
            else
                $this->view->response("The review was not deleted", 500);
        }
    }
}
