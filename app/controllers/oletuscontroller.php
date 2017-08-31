<?php

class OletusController extends BaseController {

    public static function hakusivu($hakusana) {
        self::check_logged_in();
        $kayttajat = Kayttaja::etsiKayttajaNimella($hakusana);
        $viestit = Viesti::viestiEtsinta($hakusana);
        $tagit = Tagi::etsiNimella($hakusana);
        View::make('yleis/hakusivu.html', array('kayttajat' => $kayttajat, 'viestit' => $viestit, 'tagit' => $tagit, 'hakusana' => $hakusana));
    }
    
    public static function etusivu() {
        self::check_logged_in();
        View::make('yleis/etusivu.html');
    }

    public static function poistaViimeinenOR($kysely) {
        if (($paikka = strrpos($kysely, 'OR')) !== false) {
            $search_length = strlen('OR');
            $kysely = substr_replace($kysely, '', $paikka, $search_length);
        }
        return $kysely;
    }
}
