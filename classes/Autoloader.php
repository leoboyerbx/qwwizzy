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
        $class_path = explode('\\', $class);
        $class_path = implode('/', $class_path);
        require ROOT . "/classes/$class_path.php";
    }

    /**
     * Enregistre l'autoloader auprès du process PHP
     */
    static function register() {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
}