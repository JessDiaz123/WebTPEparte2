Servicio Web API REST de Peliculas.com 


Importar la base de datos

importar desde PHPMyAdmin (o cualquiera) database/db_movies.php

Sobre la aplicacion: 
Esta API sigue el estandar RESTful.
Permite obtener las peliculas de nuestro sitio, asi como ver,crear,modificar y borrar a las reseñas de dichas peliculas. 
Tambien se brinda el servicio de listar las peliculas del sitio de forma ascendente o descendente segun un campo en particular
y puede paginarse. 


ENDPOINTS 
El endpoint de la API es: http://localhost/Web2/Web2TPEParte2/api/peliculas

### API Endpoints
| HTTP Verbs | Endpoints | Action |
| --- | --- | --- |

``| GET | /api/peliculas| obtiene un listado de todas las peliculas del sitio|``
``| GET | /api/peliculas?sort=:columna&order=asc/desc obtiene un listado de todas las peliculas del sitio, ordenados de forma ascendente o descendente segun una columna elegida(vease columnas permitidas en el apartado: )|``
``| GET | /api/peliculas/:ID| obtiene el detalle de una pelicula en particular|``
``| GET | /api/peliculas/:ID/resenia| obtiene todas las reseñas de una pelicula en particular|``
``| GET | /api/peliculas/:ID/resenia/:IDRESEÑA| obtiene el detalle de una RESEÑA en particular|``
``
``| PUT | /api/peliculas/:ID/resenia/:IDRESEÑA| Permite modificar una reseña de la pelicula seleccionada |``
``| POST | /api/peliculas/:ID/resenia| Permite crear una nueva reseña de la pelicula seleccionada |``

`` | DELETE | /api/peliculas/:ID/resenia/:IDRESEÑA| Permite eliminar una reseña de la pelicula seleccionada |``


Ordenamiento: 
Columnas permitidas: movieName, director, movieLength, genre.
Ordenes permitidos: asc, desc (ascendente y descendente)

Paginacion 
/api/peliculas/:ID/resenias?limit=4&page=1

aclaracion: page y limit siempre deben ser mayor a 0.

