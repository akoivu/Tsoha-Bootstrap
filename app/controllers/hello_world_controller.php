<?php

class YleisController extends BaseController {

    public static function kayttaja($kayttajaId) {
        self::check_logged_in();
        $kayttaja = Kayttaja::findId($kayttajaId);
        $viestit = Viesti::findMessageByKayttaja($kayttajaId);

        View::make('kayttaja/kayttajasivu.html', array('kayttaja' => $kayttaja, 'viestit' => $viestit));
    }

    public static function hakusivu($hakusana) {
        self::check_logged_in();
        $kayttajat = Kayttaja::findUserName($hakusana);
        $viestit = Viesti::findMessage($hakusana);
        $tagit = Tagi::findName($hakusana);
        View::make('yleis/hakusivu.html', array('kayttajat' => $kayttajat, 'viestit' => $viestit, 'tagit' => $tagit, 'hakusana' => $hakusana));
    }

    public static function viestisivu($keskustelualueId) {
        self::check_logged_in();
        $viestit = Viesti::findMessageByKeskustelualue($keskustelualueId);
        $keskustelualue = Keskustelualue::findId($keskustelualueId);
        View::make('viesti/viestisivu.html', array('viestit' => $viestit, 'keskustelualue' => $keskustelualue));
    }
    
    public static function sandbox() {
        
    }
    
    public static function etusivu() {
        self::check_logged_in();
        View::make('yleis/etusivu.html');
    }

}
