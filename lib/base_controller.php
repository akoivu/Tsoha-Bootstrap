<?php

class BaseController {

    public static function get_user_logged_in() {
        if(isset($_SESSION['user'])) {
            $kayttajaId = $_SESSION['user'];
            
            $kayttaja = Kayttaja::findId($kayttajaId);
            
            return $kayttaja;
        }
        
        return null;
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
        
        if(!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään'));
        }
    }

}
