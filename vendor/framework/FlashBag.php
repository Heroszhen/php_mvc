<?php

namespace vendor\framework;

class FlashBag
{
    public function __construct()
    {   
        $bStatut = false;
        if (php_sapi_name() !== 'cli' ) {
            $bStatut = (session_status() === PHP_SESSION_ACTIVE ? true : false);
        }    
        if ($bStatut === false) session_start();
    }
 
    /**
     * Enregistrement d'un message
     * @param string message à afficher
     * @param string type success | warning
     */
    public function set($message, $type = 'success')
    {
        $_SESSION['flashbag'] = [
            'message' => $message,
            'type'  => $type
        ];
    }

    /**
    * Retourne le message et le type de message se trouvant dans
    * la session flash (tableau vide si pas de message)
    *
    * @return array
    */
    public function get()
    {
        $return = [];
        if (isset($_SESSION['flashbag']) && is_array($_SESSION['flashbag'])) {
            $return = $_SESSION['flashbag'];
            // Le principe des sessions flash étant qu'elles sont utilisées 
            // qu'une seule fois donc on supprime pendant le Get
            unset($_SESSION['flashbag']);
        }
        return $return;
    }
 
    /**
     * empty flashbag
     */
    public function empty(){
        $_SESSION['flashbag'] = null;
    }
}