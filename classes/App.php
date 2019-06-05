<?php
/**
 * Classe globale pour notre Application
 * Elle utilise le principe du singleton
 *
 */

class App {
    private static $_instance;
    private $bdd_instance;
    /**
     * Fonction GetInstance: stocke une unique instance de notre application.
     * Permet de gérer l'instance unique de la classe
     * @return App
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    /**
     * Renvoie le contenu d'un fichier de configuration dont l'adresse est passée en paramètre
     * @param $fichier
     * @return array
     */
    private function configFile($fichier) {
        $config = require(ROOT . $fichier);
        return $config;
    }

    /**
     * Renvoie une instance de l'objet MysqlBdd. Si l'instance n'existe pas encore, elle est créée.
     * @return \Bdd\MysqlBdd
     */
    public function getBdd() {
        if ($this->bdd_instance === null) {
            $config = $this->configFile('/config/config.php');
            if (!empty($config['db_port'])) {
                $this->bdd_instance = new Bdd\MysqlBdd($config['db_name'], $config['db_user'], $config['db_pass'], $config['db_host'], $config['db_port']);
            } else {
                $this->bdd_instance = new Bdd\MysqlBdd($config['db_name'], $config['db_user'], $config['db_pass'], $config['db_host']);
            }
        }
        return $this->bdd_instance;
    }


    /**
     * Recupère la valeur d'une configuration depuis la table "config"
     * @param $key
     * @return bool|mixed
     */
    public function getConfig($key) {
        $req = $this->getBdd()->prepare('SELECT * FROM config WHERE clef = ?', [$key], null, true);
        if ($req) {
            return json_decode($req->valeur);
        }
        return false;
    }

    /**
     * Définit la valeur d'une configuration depuis la table "config"
     * @param $key
     * @param $val
     * @return array|bool|mixed
     */
    public function setConfig($key, $val) {
        $req = $this->getBdd()->prepare('UPDATE config SET valeur=? WHERE clef=?', [$val, $key]);
        return $req;
    }

    /**
     * function load()
     * Appelée à chaque chargement, démarre la session et met en place l'autoloader, pour éviter de devoir charger les classes à la main.
     */
    public function load() {
        require ROOT . '/classes/Autoloader.php';
        Autoloader::register();
        session_start();
    }

    /**
     * Stocke dans la session un message "flash" qui est destiné à être récupéré et affiché plus tard.
     *
     * @param $type
     * @param $message
     */
    public function set_flash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
            ];
    }

    /**
     * Renvoie s'il existe le message flash stocké dans la session et le formate pour être visible comme alerte Bootstrap.Efface ensuite le message de la session.
     * @return string
     */
    public function get_flash() {
        if (!empty($_SESSION['flash'])) {
            $flash = '<div class="flashmsg alert alert-'. $_SESSION['flash']['type'] .'" data-type="'. $_SESSION['flash']['type'].'">
         ' . $_SESSION['flash']['message'] ."
        </div>";
        unset($_SESSION['flash']);
        return $flash;
    
        }
    }

    /**
     * Méthode chargée de l'upload d'un fichier sur le serveur. Elle est utilisée pour le changement de photo de profil.
     * @param $file L'objet fichier généré par l'envoi de formulaire
     * @param string $dest_path Le chemin où enregistrer le fichier
     * @param string $dest_name Le nom de fichier à enregistrer
     * @param int $maxsize La taille maximale autorisée (avec une valeur par défaut)
     * @param array $extensions_valides La liste des extensions acceptées (valeur par défaut pour les images)
     * @return array Renvoie un tableau qui indique le succès, l'erreur et le chemin du fichier.
     */
    public function upload($file, $dest_path, $dest_name, $maxsize = 8388608, $extensions_valides = ['jpg' , 'jpeg' , 'gif' , 'png']) {
        // On commence par vérifier qu'il n'y a pas d'érreurs.
        if ($file['error'] > 0) $erreur = "Erreur lors du transfert";
        if ($file['size'] > $maxsize) $erreur = "Le fichier est trop gros";

        $extension_upload = strtolower(  substr(  strrchr($file['name'], '.')  ,1)  ); // On récupère l'extension du fichier envoyé
        
        $full_name = $dest_name.'.'. $extension_upload; // Le nom de fichier avec l'extension
        $full_path = $dest_path.'/'. $full_name; //Le chemin complet avec l'extention de fichier

        // On empêche les extensions non approuvées.
        if (!in_array($extension_upload,$extensions_valides) ) $erreur = "Extension incorrecte: uniquement des fichiers jpg ou png ou gif";
        if (empty($erreur)) {
            /**
             * Si tout s'est bien passé jusqu'ici, on enregistre le fichier uploadé, et on renvoie un succès.
             */
            if (move_uploaded_file($file['tmp_name'], $full_path)) {
                $success = true;
            } else {
                $success = false;
            }
        } else {
            /**
             * S'il y a eu une erreur, $success est faux.
             */
            $success = false;
        }
        /**
         * On renvoie un tableau avec le résultat de l'opération.
         */
        return [
            "success" => $success,
            "error" => $erreur,
            "path" => $full_path,
            "name" => $full_name
            ];
       }

    /**
     * Définit un message flash indiquant un accès interdit et redirige à la racine de l'admin.
     */
    public function interdit() {
        $this->set_flash('danger', "Vous n'avez pas le droit d'accéder à cette page");
        header('Location: /admin');
        die();
    }

    /**
     * Renvoie un tableau contenant les correspondances entre les niveaux d'autoristions et leurs numéros. Stocké dans la table config.
     * @return array
     */
    public function toutes_permissions () {
        // return array(
        //     '10' => 'Administrateur',
        //     '7' => 'Éditeur',
        //     '5' => 'Auteur',
        //     '3' => 'Visiteur'
        // );
        return (array) $this->getConfig('permissions');
    }

    /**
     * A partir du tableau de persmissions et d'un entier correspondants au niveau de permissions, renvoie le nom correspondant à ce niveau.
     * @param $permInt
     * @return mixed|string
     */
    public function get_permission_nom ($permInt) {
        // On récupère toutes les permissions
        $allPermissions = $this->toutes_permissions();
        $permName = "";

        // On parcourt le tableau à la recherche d'une occurence
        foreach($allPermissions as $int => $permissionName) {
            if ($permInt >= $int) {
                $permName = $permissionName;
                break;
            }
        }
        return $permName;
    }

    /**
     * Raccourci de la méthode verif_permission de la classe Auth, mais avec la dépendance Bdd déjà injectée. Voir Bdd/Auth.php
     * @param $permInt
     * @return bool
     */
    public function auth_verif_permissions ($permInt) {
        $auth = new Bdd\Auth($this->getBdd());
        return $auth->verif_permissions($permInt);
    }

    /**
     * Envoie les variables CSS correspondant aux couleurs du thèle du site, stocké dans la table config
     * @return string
     */
    public function getThemeColor() {
        // On récupère l'entrée de configuration dans la base de données, si l'entrée existe
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