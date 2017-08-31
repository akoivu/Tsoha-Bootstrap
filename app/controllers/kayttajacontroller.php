<?php

class KayttajaController extends BaseController {
    
    public static function kirjautumissivu() {
        View::make('yleis/kirjautuminen.html');
    }
    
    public static function kirjautuminen() {
        $parametrit = $_POST;
        
        $kayttaja = Kayttaja::authenticate($parametrit['nimi'], $parametrit['salasana']);
        
        if(!$kayttaja) {
            View::make('yleis/kirjautuminen.html', array('virheet' => array('Väärä käyttäjänimi ja/tai salasana.'), 'nimi' => $parametrit['nimi']));
        } else {
            $_SESSION['user'] = $kayttaja->kayttajaId;
            Redirect::to('/', array('info' => 'Olet onnistuneesti kirjautunut sisään.'));
        }
    }
    
    public static function store() {
        $rivi = $_POST;
        
        $attribuutit = array(
            'nimi' => $rivi['nimiuusi'],
            'liittymispaiva' => date('d-m-Y H:i:s'),
            'lempivari' => '',
            'esittelyteksti' => '',
            'salasana' => $rivi['salasanauusi'],
            'admin' => 'FALSE'
        );
        
        $kayttaja = new Kayttaja($attribuutit);
        
        $virheet = array_merge($kayttaja->errors(), $kayttaja->validate_uniikkius());
        
        if(count($virheet) == 0) {
            $kayttaja->tallenna();
            $_SESSION['user'] = $kayttaja->kayttajaId;
            Redirect::to('/kayttajat/' . $kayttaja->kayttajaId, array('info' => 'Rekisteröityminen onnistui. Muista lisätä lempivärisi ja esittelytekstisi halutessasi.'));
        } else {
            View::make('yleis/kirjautuminen.html', array('virheet' => $virheet));
        }
    }
    
    public static function tietojenMuokkaus($kayttajaId) {
        self::check_logged_in();
        $kayttaja = Kayttaja::idEtsinta($kayttajaId);
        View::make('kayttaja/tietojenmuokkaus.html', array('kayttaja' => $kayttaja));
    }
    
    public static function update($kayttajaId) {
        self::check_logged_in();
        $rivi = $_POST;
        
        $vanha = Kayttaja::idEtsinta($kayttajaId);
        
        $attributes = array(
            'kayttajaId' => $kayttajaId,
            'nimi' => $vanha->nimi,
            'lempivari' => $rivi['vari'],
            'esittelyteksti' => $rivi['teksti'],
            'salasana' => $vanha->salasana,
            'liittymispaiva' => $vanha->liittymispaiva,
            'admin' => $vanha->admin
        );
        
        $uusi = new Kayttaja($attributes);
        
        $virheet = $uusi->errors();
                        
        if(count($virheet) > 0) {
            View::make('kayttaja/tietojenmuokkaus.html', array('virheet' => $virheet, 'kayttaja' => $uusi));
        } else {
            $uusi->paivita();
            Redirect::to('/kayttajat/' . $uusi->kayttajaId, array('info' => 'Tiedot on päivitetty'));
        }
    }
    
    public static function poista($kayttajaId) {
        self::check_logged_in();
        $kayttaja = new Kayttaja(array('kayttajaId' => $kayttajaId));
        
        $kayttaja->poista();
        
        Redirect::to('/login', array('info' => 'Käyttäjä poistettu'));
    }
    
    public static function kayttajat() {
        self::check_logged_in();
        $kayttajat = Kayttaja::listaaKaikki();
        
        View::make('kayttaja/kayttajat.html', array('kayttajat' => $kayttajat));
    }
    
    public static function kayttaja($kayttajaId) {
        self::check_logged_in();
        $kayttaja = Kayttaja::idEtsinta($kayttajaId);
        $viestit = Viesti::etsiKayttajanViestit($kayttajaId);

        View::make('kayttaja/kayttajasivu.html', array('kayttaja' => $kayttaja, 'viestit' => $viestit));
    }
    
    public static function uloskirjautuminen() {
        self::check_logged_in();
        $_SESSION['user'] = null;
        Redirect::to('/login', array('info' => 'Olet kirjautunut ulos!'));
    }
}
