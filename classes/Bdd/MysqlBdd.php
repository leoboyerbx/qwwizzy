<?php
namespace Bdd;


use \PDO;
/**
 * Class Database: Outil de connexion à la Base de données
 * @package App
 */
class MysqlBdd {
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $db_port;
    private $pdo;
    
    public function __construct($db_name, $db_user = 'root', $db_pass='root', $db_host='localhost', $db_port="3306") {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
    }
    private function getPDO() { // Permet de récupérer l'objet PDO
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host.';port='. $this->db_port .';charset=UTF8', $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
    public function query($statement, $one = false) {
        $req = $this->getPDO()->query($statement);
        // Si il y a une insertion, on retourne directement le résultat
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) { return $req; }
        $req->setFetchMode(PDO::FETCH_OBJ);
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
    public function prepare($statement, $attributes, $class_name = null, $one = false) {
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attributes);
        // Si il y a une insertion, on retourne directement le résultat
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) { return $res; }
        $req->setFetchMode(PDO::FETCH_OBJ);
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
    // public function lastInsertId() {
    //     return $this->getPDO()->lastInsertId();
    // }
}