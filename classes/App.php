<?php
/**
 * Classe globale pour notre App
 */

class App {
    private static $_instance;

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

    public function load() {
        require ROOT . '/classes/Autoloader.php';
        Autoloader::register();
    }
}