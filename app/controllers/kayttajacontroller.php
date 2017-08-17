<?php

class KayttajaController extends BaseController {
    
    public static function kirjautumissivu() {
        View::make('kirjautuminen.html');
    }
    
    public static function kirjautuminen() {
        $params = $_POST;
        
        $kayttaja = Kayttaja::authenticate($params['nimi'], $params['salasana']);
        
        if(!$kayttaja) {
            View::make('kirjautuminen.html', array('error' => 'Väärä käyttäjänimi ja/tai salasana.', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['user'] = $kayttaja->kayttajaId;
            Redirect::to('/', array('message' => 'Olet onnistuneesti kirjautunut sisään.'));
        }
    }
    
    public static function store() {
        $rivi = $_POST;
        
        $attributes = array(
            'nimi' => $rivi['nimiuusi'],
            'liittymispaiva' => date('d-m-Y H:i:s'),
            'lempivari' => '',
            'esittelyteksti' => '',
            'salasana' => $rivi['salasanauusi'],
            'admin' => 'FALSE'
        );
        
        $kayttaja = new Kayttaja($attributes);
        
        $errors = $kayttaja->errors();
        
        $errors = array_merge($errors, $kayttaja->validate_nimi());
        
        if(count($errors) == 0) {
            $kayttaja->save();
            $_SESSION['user'] = $kayttaja->kayttajaId;
            Redirect::to('/kayttajat/' . $kayttaja->kayttajaId, array('message' => 'Rekisteröityminen onnistui. Muista lisätä lempivärisi ja esittelytekstisi halutessasi.'));
        } else {
            View::make('kirjautuminen.html', array('errors' => $errors));
        }
    }
    
    public static function tietojenMuokkaus($kayttajaId) {
        $kayttaja = Kayttaja::findId($kayttajaId);
        View::make('tietojenmuokkaus.html', array('kayttaja' => $kayttaja));
    }
    
    public static function update($kayttajaId) {
        $rivi = $_POST;
        
        $vanha = Kayttaja::findId($kayttajaId);
        
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
        
        $errors = $uusi->errors();
                        
        if(count($errors) > 0) {
            View::make('tietojenmuokkaus.html', array('errors' => $errors, 'kayttaja' => $uusi));
        } else {
            $uusi->update();
            Redirect::to('/kayttajat/' . $uusi->kayttajaId, array('message' => 'Tiedot on päivitetty'));
        }
    }
    
    public static function poista($kayttajaId) {
        $kayttaja = new Kayttaja(array('kayttajaId' => $kayttajaId));
        
        $kayttaja->poista();
        
        Redirect::to('/', array('message' => 'Käyttäjä poistettu'));
    }
    
    public static function kayttajat() {
        $kayttajat = Kayttaja::all();
        
        View::make('kayttajat.html', array('kayttajat' => $kayttajat));
    }
}
