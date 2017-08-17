<?php

class HelloWorldController extends BaseController {

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

    public static function viestisivu($keskustelualueId) {
        $viestit = Viesti::findMessageByKeskustelualue($keskustelualueId);
        $keskustelualue = Keskustelualue::findId($keskustelualueId);
        View::make('viestisivu.html', array('viestit' => $viestit, 'keskustelualue' => $keskustelualue));
    }

    public static function joku() {
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
    
    public static function sandbox() {
        $kayttaja = new Kayttaja(array(
            'nimi' => 'Abrahvjhvjh',
            'liittymispaiva' => date('d-m-Y H:i:s'),
            'lempivari' => '',
            'esittelyteksti' => '',
            'admin' => FALSE,
            'salasana' => 'nkbjjhbvjvh'
        ));
        
        $errors = $kayttaja->errors();
        
        Kint::dump($errors);
    }
    
    public static function etusivu() {
        View::make('etusivu.html');
    }

}
