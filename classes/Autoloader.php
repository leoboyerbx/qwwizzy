<?php
/**
 * Classe Autoloader pour importer automatiquement les classes nécessaires
 */

class Autoloader {
    /**
     * La fonction autoloader en elle même
     * @param $class Le nom de la classe
     */
    static function autoload($class) {
        // On sépare le nom de la classe entre ses namespaces
        $class_path = explode('\\', $class);
        // On transforme ça en chemin pour trouver le fichier php
        $class_path = implode('/', $class_path);
        // On inclut le PHP
        require ROOT . "/classes/$class_path.php";
    }

    /**
     * Enregistre l'autoloader auprès du process PHP
     */
    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
}