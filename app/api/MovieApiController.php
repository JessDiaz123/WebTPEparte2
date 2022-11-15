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

    //obtiene todas las peliculas (sort,order)
    function getAll()
    {
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $this->getAllMoviesSorted($_GET['sort'], $_GET['order']);
        } else {
            $movies = $this->model->showAll();
            $this->view->response($movies, 200);
        }
    }
    //funcion complementaria, obtiene las peliculas ordenadas
    function getAllMoviesSorted($column, $asc)
    {
        $columns = ["movieName", "movieLength", "director", "genre"];
        $order = ["asc", "desc"];
        if (in_array($column, $columns) && in_array($asc, $order)) {
            $movies = $this->model->getAllMoviesSorted($column, $asc);
            $this->view->response($movies, 200);
        } else {
            $this->view->response("bad request", 400);
        }
    }
    //obtiene 1 pelicula
    function getOne($params = null)
    {
        $movie = $this->verifyMovie($params);
        if ($movie) {
            $this->view->response($movie);
        }
    }

    function verifyMovie($params = null)
    {
        $id = $params[':ID'];
        if (is_numeric($id)) {
            $movie = $this->model->getOneItem($id);
            if ($movie)
                return $movie;
            else
                $this->view->response("movie not found", 404);
        } else {
            $this->view->response("bad request", 400);
        }
    }

    /*========================================================================
    =============================== Reviews ==================================
    ========================================================================*/

    //get all de reviews
    function getReviewsForOneMovie($params = null)
    {
        if ($this->verifyMovie($params)) { // verifico que exista la pelicula
            $pagination = $this->verifyPagination($params); // verifico que la paginacion tenga parametros correctos
            if ($pagination) { // paginacion siempre va a tener porque yo se lo seteo por defecto, pero esto es por //para controlar el null (por si ingresaron mal el parametro).                
                $id =  $params[':ID'];
                //==============Orden==============    
                $reviews = $this->verifySorted($id);

                //==============Filtro==============
                $filter = $this->verifyFilter();
                if ($filter) { // si tiene filtro permitido
                    $aux = [];
                    foreach ($reviews as $review) {
                        if ($review->user == $filter) {
                            array_push($aux, $review);
                        }
                    }
                    $reviews = $aux;
                }
                //====================================Paginacion====================================

                $page = $pagination->page;
                $limit = $pagination->limit;
                $from = ($page - 1) * $limit;
                $reviews = array_slice($reviews, $from, $limit);

                if ($reviews) {
                    $this->view->response($reviews);
                } else {
                    $this->view->response("reviews not found", 404);
                }
            }
        }
    }


    function getOneReview($params = null)
    {
        $review = $this->verifyReview($params);
        if ($review) {
            $this->view->response($review);
        }
    }

    //funcion complementaria, obtiene las resenias ordenadas
    function getAllReviewsSorted($id, $column, $asc)
    {
        $columns = ["user", "id_review"];
        $order = ["asc", "desc"];
        if (in_array($column, $columns) && in_array($asc, $order)) {
            $movies = $this->model->getAllReviewsSorted($id, $column, $asc);
            return $movies;
        } else {
            $this->view->response("bad request, params in order are wrong", 400);
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
        if ($review) {
            $data = $this->getData();
            $newText = $data->review;
            $reviewModified = $this->model->modifyReview($review->id_review, $newText);
            if ($reviewModified)
                $this->view->response("The review was modified successfully", 200);
            else
                $this->view->response(" The review was not modified", 500);
        }
    }

    function removeReview($params = null)
    {
        $review = $this->verifyReview($params);
        if ($review) {
            $result = $this->model->deleteReview($review->id_review);
            if ($result)
                $this->view->response("review id=$review->id_review was deleted successfully");
            else
                $this->view->response("The review was not deleted", 500);
        }
    }

    function badRequestURL()
    {
        $this->view->response("bad request, enter a valid URL ", 400);
    }

    /*========================================================================
    ============================= Auxiliares ================================
    ========================================================================*/

    function verifyFilter($params = null)
    {
        $enabledFiltes = ["user"];
        if (isset($_GET["user"])) {
            return $_GET["user"];
        } else {
            return null;
        }
    }

    function verifyPagination()
    {
        if (isset($_GET['limit']) && isset($_GET['page'])) {
            if (
                is_numeric($_GET['limit']) && is_numeric($_GET['page']) && $_GET['limit'] > 0
                && $_GET['page'] > 0
            ) {
                $limit = $_GET['limit'];
                $page = $_GET['page'];
            } else {
                $this->view->response("bad request, ingrese numeros correctos", 400);
                return null;
            }
        } else {
            $limit = 10;
            $page = 1;
        }

        $order = new stdClass();
        $order->page = $page;
        $order->limit = $limit;

        return $order;
    }

    function verifyReview($params = null)
    {
        if ($this->verifyMovie($params)) {
            $idRES = $params[':IDRESEÑA'];
            if (is_numeric($idRES) && $idRES >= 0) {
                $review = $this->model->getOneReview($idRES);
                if ($review) {
                    return $review;
                } else {
                    $this->view->response("review not found", 404);
                    return false;
                }
            } else {
                $this->view->response("bad request, enter a valid id for the review ", 400);
                return false;
            }
        } else {
            return false;
        }
    }
    function verifySorted($id)
    {
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $reviews = $this->getAllReviewsSorted($id, $_GET['sort'], $_GET['order']);
        } else {
            $reviews = $this->model->getReviewsForOneMovie($id);;
        }
        return $reviews;
    }
}
