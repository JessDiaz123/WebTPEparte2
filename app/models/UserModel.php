<?php

class UserModel {
    private $db;

    
    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=db_movies;charset=utf8', 'root', '');
    }

    public function getUserByEmail($email) {
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $query->execute([$email]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
}