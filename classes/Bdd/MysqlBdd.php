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
    
    /**
     * Lors de la création d'une instance, on stocke les identifiants dans l'objet
     */
    public function __construct($db_name, $db_user = 'root', $db_pass='root', $db_host='localhost', $db_port="3306") {
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
    }
    /**
     * Permet de récupérer un unique objet PDO
     */
    private function getPDO() {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host.';port='. $this->db_port .';charset=UTF8', $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
    
    /**
     * Exécute une requête, et renvoie le résultat sour forme de tableau.
     * @param $statement La requête
     * @param $class_name la classe à utiliser pour le résultat
     * @param $one si on n'attend qu'un seul élément
     */
    public function query($statement, $class_name=null, $one = false) {
        // On éxécute la requête
        $req = $this->getPDO()->query($statement);
        // Si la requete est une insertion, pas besoin de parcourir le résultat, on renvoie directement le résultat
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) { return $req; }
        
        // On affecte un nom de classe si le paramètre est spécifié
        if ($class_name === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        
        // Si on attend un seul résultat, ou plusieurs, on agit différemment
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
    /**
     * Identique à query() mais utilise une requete préparée
     */
    public function prepare($statement, $attributes, $class_name = null, $one = false) {
        $req = $this->getPDO()->prepare($statement);
        $res = $req->execute($attributes);
        // Si il y a une insertion, on retourne directement le résultat
        if (
            strpos($statement, 'UPDATE') === 0 ||
            strpos($statement, 'INSERT') === 0 ||
            strpos($statement, 'DELETE') === 0
        ) { return $res; }
        
        if ($class_name === null) {
            $req->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        }
        
        if ($one) {
            $data = $req->fetch();
        } else {
            $data = $req->fetchAll();
        }
        return $data;
    }
}