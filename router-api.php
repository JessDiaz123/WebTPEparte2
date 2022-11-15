
<?php
require_once 'libs/Router.php';
require_once 'app/api/MovieApiController.php';
require_once 'app/api/ApiAuthController.php';

// crea el router
$router = new Router();

// Decidi dejar por defecto 
$router->setDefaultRoute('MovieApiController',
'badRequestURL');

// define la tabla de ruteo
$router->addRoute('peliculas', 'GET', 'MovieApiController',
 'getAll'); // todas las peliculas
$router->addRoute('peliculas/:ID', 'GET', 'MovieApiController',
 'getOne'); //una pelicula en particular
$router->addRoute('peliculas/:ID/resenias', 'GET', 'MovieApiController', 
'getReviewsForOneMovie');// todas las reseñas de una peli
$router->addRoute('peliculas/:ID/resenias/:IDRESEÑA', 'GET', 'MovieApiController',
 'getOneReview'); // una reseña en particular
$router->addRoute('peliculas/:ID/resenias', 'POST', 'MovieApiController', 
'addReview'); // crear una nueva reseña
$router->addRoute('peliculas/:ID/resenias/:IDRESEÑA', 'PUT', 'MovieApiController', 
'modifyReview'); // Modificar una reseña
$router->addRoute('peliculas/:ID/resenias/:IDRESEÑA', 'DELETE', 'MovieApiController',
 'removeReview'); // borrar una reseña
$router->addRoute('auth/token','GET','ApiAuthController','getToken');

$resource = $_GET["resource"];

$method = $_SERVER['REQUEST_METHOD'];

// rutea
$router->route($resource,$method);


