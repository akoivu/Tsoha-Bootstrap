<?php

class HelloWorldController extends BaseController {

    public static function index() {
        $keskustelualueet = Keskustelualue::all();
        View::make('etusivu.html', array('keskustelualueet' => $keskustelualueet));
    }

    public static function kayttaja($kayttajaId) {
        $kayttaja = Kayttaja::findId($kayttajaId);
        $viestit = Viesti::findMessageByKayttaja($kayttajaId);

        View::make('kayttajasivu.html', array('kayttaja' => $kayttaja, 'viestit' => $viestit));
    }

    public static function hakusivu($hakusana) {
        $kayttajat = Kayttaja::findUserName($hakusana);
        $viestit = Viesti::findMessage($hakusana);
        View::make('hakusivu.html', array('kayttajat' => $kayttajat, 'viestit' => $viestit, 'hakusana' => $hakusana));
    }

    public static function kirjautuminen() {
        View::make('kirjautuminen.html');
    }

    public static function tietojenMuokkaus($kayttajaId) {
        $kayttaja = Kayttaja::findId($kayttajaId);
        View::make('tietojenmuokkaus.html', array('kayttaja' => $kayttaja));
    }

    public static function viestisivu($keskustelualueId) {
        $viestit = Viesti::findMessageByKeskustelualue($keskustelualueId);
        $keskustelualue = Keskustelualue::findId($keskustelualueId);
        View::make('viestisivu.html', array('viestit' => $viestit, 'keskustelualue' => $keskustelualue));
    }

    public static function sandbox() {
        $keskustelualueet = Keskustelualue::all();
        Kint::dump($keskustelualueet);
    }

    public static function store() {
        $rivi = $_POST;

        $keskustelualue = new Keskustelualue(array(
            'nimi' => $rivi['nimi'],
            'maara' => 0
        ));
                
        $keskustelualue->save();
        
        Redirect::to('/alueet/' . $keskustelualue->keskustelualueId, array('message' => 'Uusi keskustelualue on syntynyt!'));
    }

}
