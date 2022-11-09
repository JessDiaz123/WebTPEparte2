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

    function getAll()
    {
        $movies = $this->model->showAll($params = null);
        $this->view->response($movies, 200);
    }


    //por el router que tenemos, recibimos los parametros mediante un 
    // arreglo asociativo. (al que accedemos con $params['elParametro'])
    function getReviewsForOneMovie($params = null)
    {
        $id =  $params[':ID'];
        if ($id) {
            $review = $this->model->getReviewsForOneMovie($id);
            if ($review) {
                $this->view->response($review);
            } else {
                $this->view->response("reviews not found", 404);
            }
        } else {
            $this->view->response("movie not found", 404);
        }
    }

    function getOneReview($params = null)
    {
        $id =  $params[':ID'];
        if ($id) {
            $idRES =  $params[':IDRESEÑA'];
            $review = $this->model->getOneReview($idRES);
            if ($review) {
                $this->view->response($review);
            } else {
                $this->view->response("review doesn't found", 404);
            }
        } else {
            $this->view->response("movie not found", 404);
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
            if (is_numeric($idRES)){
                $review = $this->model->getOneReview($idRES);
                if($review){
                    return $review;
                }
                else{
                    $this->view->response("review not found", 404); 
                    die();
                }
            } 
            else {
                $this->view->response("ingrese un id  valido para la reseña ", 404);
            }
    } 
    

    function verifyMovie($params=null){
        $id = $params[':ID'];
        if($id) {
            $movie = $this->model->getOneItem($id);
            return $movie;
        }
        else{
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
            $id = $this->model->addReview($review, $movie->id_movie);
            $review = $this->model->getOneReview($id);
            if ($review)
                $this->view->response("la reseña fue creada con exito", 201);
            else
                $this->view->response(" La reseña no fue creada", 500);
        }
    }
    function modifyReview($params = null){
        $review = $this->verifyReview($params);
        $data = $this->getData();
        $newText = $data->review;
        $reviewModified = $this->model->modifyReview($review->id_review,$newText);
        if ($reviewModified)
            $this->view->response("La reseña fue modificada con exito", 200);
        else
            $this->view->response(" La reseña no fue modificada", 500);
}
function removeReview ($params = null){
    $review = $this->verifyReview($params);
    if($review){
        $result = $this->model->deleteOneReview($review->id_review);
        if($result)
            $this->view->response("review id=$review->id_review was deleted successfully");
        else
            $this->view->response(" La reseña no fue modificada", 500);
        
    }
}

function getAllSorted($params=null){

    $movies = $this->model->getAllSorted("movieName","ASC");
    $this->view->response($movies, 200);
}



}




