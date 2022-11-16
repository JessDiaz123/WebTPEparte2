Servicio Web API REST de Peliculas.com

Importar la base de datos

importar desde PHPMyAdmin (o cualquiera) database/db_movies.php

Sobre la aplicacion:
Esta API sigue el estandar RESTfull.
Permite obtener las peliculas de nuestro sitio, asi como ver,crear,modificar y borrar a las reseñas de dichas peliculas.
Tambien se brinda el servicio de listar las peliculas del sitio y sus reseñas de forma ascendente o descendente segun un campo en particular, permite paginar, y filtrar por campos determinados.

ENDPOINTS
El endpoint de la API es: http://localhost/Web2/Web2TPEParte2/api/peliculas

### API Endpoints

| HTTP Verbs | Endpoints | Action |
| ---------- | --------- | ------ |

| GET | /api/peliculas| obtiene un listado de todas las peliculas del sitio|
| GET | /api/peliculas/:ID | obtiene el detalle de una pelicula en particular|
| GET | /api/peliculas/:ID/resenias | obtiene todas las reseñas de una pelicula en particular|
| GET | /api/peliculas/:ID/resenias/:IDRESEÑA | obtiene el detalle de una RESEÑA en particular|
| GET | /api/auth/token | Logueandose, obtiene permiso para eliminar reseñas|

| PUT | /api/peliculas/:ID/resenias/:IDRESEÑA| Permite modificar una reseña de la pelicula seleccionada | *vease apratado REQUERIMIENTOS PUT*

| POST | /api/peliculas/:ID/resenias | Permite crear una nueva reseña de la pelicula seleccionada | *vease apratado REQUERIMIENTOS POST*

| DELETE | /api/peliculas/:ID/resenias/:IDRESEÑA | Permite eliminar una reseña de la pelicula seleccionada (Necesita verificacion de Token)|






#### ORDENAMIENTO(Peliculas):

obtiene un listado de todas las peliculas del sitio, ordenados de forma ascendente o descendente segun una columna elegida(vease columnas permitidas)

*Aclaracion*
| GET | /api/peliculas?sort=:columna&order=asc 
Columnas permitidas: movieName, director, movieLength, genre.
Ordenes permitidos: asc, desc (ascendente y descendente)

#### ORDENAMIENTO(Reseñas):

obtiene un listado de todas las reseñas de una pelicula en particulas, ordenados de forma ascendente o descendente segun una columna elegida (vease columnas permitidas)

| GET | /api/peliculas/resenias?sort=columna&order=asc 

*Aclaracion*
Columnas permitidas: user, id_review
Ordenes permitidos: asc, desc (ascendente y descendente)


#### PAGINACION

Agregue parámetros de consulta a las solicitudes GET:

| GET | /api/peliculas/:ID/resenias?limit=4&page=1

*aclaracion:*
page y limit siempre deben ser mayor a 0.
el paginado por defecto retornara la pagina 1, 10 registros.


#### BUSQUEDA Y FILTRADO

| GET | /api/peliculas/37/resenias?user=Lewis Capaldi

con este filtro podemos encontrar todas las reseñas que haya escrito un usuario en una pelicula determinada.



*REQUERIMIENTOS PUT*
se deben enviar obligatoriamente 1 parametro dentro de un JSON: 
{
    "review" : "Lo que el usuario quiera escribir"
}

*REQUERIMIENTOS POST*
se deben enviar obligatoriamente 2 parametros dentro de un JSON: 
{
    "user": "nombre del usuario",
    "review" : "Lo que el usuario quiera escribir"
}

#### VERIFICACION TOKEN

| GET | /api/auth/token |
Utilizando este endpoint, y enviando un usuario y contraseña valido, usted podra 
adquirir un token por tiempo limitado que le permitira borrar reseñas. 

Contacto: jesusdiaz013@gmail.com