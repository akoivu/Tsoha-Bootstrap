<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('etusivu.html');
    }

    public static function kayttajasivu() {
        // Testaa koodiasi täällä
        View::make('kayttajasivu.html');
    }

    public static function hakusivu() {
        View::make('hakusivu.html');
    }
    
    public static function kirjautuminen() {
        View::make('kirjautuminen.html');
    }
    
    public static function tietojenMuokkaus() {
        View::make('tietojenmuokkaus.html');
    }
    
    public static function viestisivu() {
        View::make('viestisivu.html');
    }
}
