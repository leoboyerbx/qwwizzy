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
        session_start();
    }
    
    public function set_flash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
            ];
    }
    
    public function get_flash() {
        if (!empty($_SESSION['flash'])) {
            $flash = '<div class="alert alert-'. $_SESSION['flash']['type'] .' role=\"alert\">
         ' . $_SESSION['flash']['message'] ."
        </div>";
        unset($_SESSION['flash']);
        return $flash;
    
        }
    }
}