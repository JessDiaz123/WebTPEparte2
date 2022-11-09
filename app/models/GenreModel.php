<?php

class GenreModel{

    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_movies;charset=utf8', 'root', '');
    }
    

function getAll(){
    //ejecuto la sentencia en 2 subpasos
    $query = $this->db->prepare("SELECT * FROM genero"); 
    $query->execute();

    //obtengo los resultados CON FETCH 
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    return $results;
}
function addNewGenre($name){

        $query = $this->db->prepare("INSERT INTO genero (genreName) VALUES (?)");
        $query->execute([$name]);
        // return $this->db->lastInsertId(); //nos devuelve el id del último elemento insertado
        //Este ultimo no andaba, preguntar porque? 
    }
    function deleteGenre($id){
        
        $query = $this->db->prepare('DELETE FROM genero WHERE id_genre = ?');
        $query->execute([$id]);

    }
    function getOneGenre($id)
    {
        $query = $this->db->prepare("SELECT * FROM genero a WHERE id_genre = ?");
        $query->execute([$id]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    function modifyGenre($id, $name)
    {
        $query = $this->db->prepare("UPDATE genero SET genreName=? WHERE id_genre=?");
        return $query->execute([$name,$id]);

    }































}
