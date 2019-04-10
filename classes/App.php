<?php
/**
 * Classe globale pour notre App
 */

class App {
    private static $_instance;
    private $bdd_instance;

    /**
     * Fonction GetInstance: stocke une unique instance de notre application.
     * Permet d'éviter d'utiliser des méthodes statiques
     * @return App
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }
    
    private function config($fichier) {
        $config = require(ROOT . $fichier);
        return $config;
    }
    
    public function getBdd() {
        if ($this->bdd_instance === null) {
            $config = $this->config('/config/config.php');
            $this->bdd_instance = new Bdd\MysqlBdd($config['db_name'], $config['db_user'], $config['db_pass'], $config['db_host']);
        }
        return $this->bdd_instance;
    }

    public function load() {
        require ROOT . '/classes/Autoloader.php';
        Autoloader::register();
    }
}