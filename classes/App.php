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
            if (!empty($config['db_port'])) {
                $this->bdd_instance = new Bdd\MysqlBdd($config['db_name'], $config['db_user'], $config['db_pass'], $config['db_host'], $config['db_port']);
            } else {
                $this->bdd_instance = new Bdd\MysqlBdd($config['db_name'], $config['db_user'], $config['db_pass'], $config['db_host']);
            }
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
    
    public function upload($file, $dest_path, $maxsize = 8388608, $extensions_valides = ['jpg' , 'jpeg' , 'gif' , 'png']) {
        if ($file['error'] > 0) $erreur = "Erreur lors du transfert";
        if ($file['size'] > $maxsize) $erreur = "Le fichier est trop gros";
        $extension_upload = strtolower(  substr(  strrchr($file['name'], '.')  ,1)  );
        if (!in_array($extension_upload,$extensions_valides) ) $erreur = "Extension incorrecte: uniquement des fichiers jpg ou png";
        if (empty($erreur)) {
            if (move_uploaded_file($file['tmp_name'],$dest_path)) {
                $success = true;
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }
        return [
            "success" => $success,
            "error" => $erreur
            ];
       }
       
    public function interdit() {
        $this->set_flash('danger', "Vous n'avez pas le droit d'accéder à cette page");
        header('Location: /admin');
        die();
    }
       
   public function toutes_permissions () {
        return array(
            '10' => 'Administrateur',
            '7' => 'Éditeur',
            '5' => 'Auteur',
            '3' => 'Visiteur'
        );
    }
    public function get_permission_nom ($permInt) {
        $allPermissions = \App::getInstance()->toutes_permissions();
        $permName = "";

        foreach($allPermissions as $int => $permissionName) {
            if ($permInt >= $int) {
                $permName = $permissionName;
                break;
            }
        }
        return $permName;
    }
}