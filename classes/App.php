<?php
/**
 * Classe globale pour notre App
 */

class App {
    private static $_instance;
    private $bdd_instance;
    private $sms_instance;

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
    
    public function getSms($mode = 'sync') {
        if ($this->sms_instance === null) {
            $config = $this->config('/config/config.php');
            $this->sms_instance = new Services\SmsApi($config['sms_api_key']);
        }
        $this->sms_instance->set_sync_mode($mode);
        
        return $this->sms_instance;
    }

    public function getConfig($key) {
        $req = $this->getBdd()->prepare('SELECT * FROM config WHERE clef = ?', [$key], null, true);
        if ($req) {
            return json_decode($req->valeur);
        }
        return false;
    }
    public function setConfig($key, $val) {
        $req = $this->getBdd()->prepare('UPDATE config SET valeur=? WHERE clef=?', [$val, $key]);
        return $req;
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
            $flash = '<div class="flashmsg alert alert-'. $_SESSION['flash']['type'] .'" data-type="'. $_SESSION['flash']['type'].'">
         ' . $_SESSION['flash']['message'] ."
        </div>";
        unset($_SESSION['flash']);
        return $flash;
    
        }
    }
    
    public function upload($file, $dest_path, $dest_name, $maxsize = 8388608, $extensions_valides = ['jpg' , 'jpeg' , 'gif' , 'png']) {
        if ($file['error'] > 0) $erreur = "Erreur lors du transfert";
        if ($file['size'] > $maxsize) $erreur = "Le fichier est trop gros";
        $extension_upload = strtolower(  substr(  strrchr($file['name'], '.')  ,1)  );
        
        $full_name = $dest_name.'.'. $extension_upload;
        $full_path = $dest_path.'/'. $full_name;
        
        if (!in_array($extension_upload,$extensions_valides) ) $erreur = "Extension incorrecte: uniquement des fichiers jpg ou png ou gif";
        if (empty($erreur)) {
            if (move_uploaded_file($file['tmp_name'], $full_path)) {
                $success = true;
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }
        return [
            "success" => $success,
            "error" => $erreur,
            "path" => $full_path,
            "name" => $full_name
            ];
       }
       
    public function interdit() {
        $this->set_flash('danger', "Vous n'avez pas le droit d'accéder à cette page");
        header('Location: /admin');
        die();
    }
       
   public function toutes_permissions () {
        // return array(
        //     '10' => 'Administrateur',
        //     '7' => 'Éditeur',
        //     '5' => 'Auteur',
        //     '3' => 'Visiteur'
        // );
        return (array) $this->getConfig('permissions');
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
    
    public function auth_verif_permissions ($permInt) {
        $auth = new Bdd\Auth($this->getBdd());
        return $auth->verif_permissions($permInt);
    }
    
    public function getThemeColor() {
        $couleurs = $this->getConfig('theme');
        
        if ($couleurs) {
            return <<<END
            <style>
:root {
    --main-color: {$couleurs->main};
    --main-color-lighter: {$couleurs->main_lighter};
    --main-color-darker: {$couleurs->main_darker};
}
            </style>
END;
        }
    }
    
}