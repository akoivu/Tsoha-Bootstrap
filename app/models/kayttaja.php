<?php

class Kayttaja extends BaseModel {

    public $kayttajaId, $nimi, $liittymispaiva, $lempivari, $esittelyteksti, $salasana, $admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_lempivari', 'validate_esittelyteksti', 'validate_salasana', 'validate_nimi');
    }

    public static function listaaKaikki() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');

        $query->execute();
        $rivit = $query->fetchAll();

        $kayttajat = array();

        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana'],
                'admin' => $rivi['admin']
            ));
        }

        return $kayttajat;
    }

    public static function findUsernameStrict($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $nimi));

        - $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana'],
                'admin' => $rivi['admin']
            ));

            return $kayttaja;
        }

        return null;
    }

    public static function idEtsinta($kayttajaId) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaId LIMIT 1');
        $query->execute(array('kayttajaId' => $kayttajaId));

        $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana'],
                'admin' => $rivi['admin']
            ));

            return $kayttaja;
        }

        return null;
    }

    public static function etsiKayttajaNimella($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi LIKE ?');
        $params = array('%' . $nimi . '%');
        $query->execute($params);

        $rivit = $query->fetchAll();

        $kayttajat = array();

        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana'],
                'admin' => $rivi['admin']
            ));
        }

        return $kayttajat;
    }

//    public static function etsiKayttajaNimellaTarkka($nimi) {
//        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi LIMIT 1');
//        $query->execute(array('nimi' => $nimi));
//        
//        $rivi = $query->fetch();
//        
//        if($rivi) {
//            $kayttaja = new Kayttaja(array(
//                'kayttajaId' => $rivi['kayttajaid'],
//                'nimi' => $rivi['nimi'],
//                'liittymispaiva' => $rivi['liittymispaiva'],
//                'lempivari' => $rivi['lempivari'],
//                'esittelyteksti' => $rivi['esittelyteksti'],
//                'salasana' => $rivi['salasana'],
//                'admin' => $rivi['admin']
//            ));
//            
//            return $kayttaja;
//        }
//        
//        return null;
//    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (nimi, liittymispaiva, salasana, admin) VALUES (:nimi, :liittymispaiva, :salasana, :admin) RETURNING kayttajaid');
        $query->execute(array('nimi' => $this->nimi, 'liittymispaiva' => $this->liittymispaiva, 'salasana' => $this->salasana, 'admin' => $this->admin));

        $rivi = $query->fetch();

        $this->kayttajaId = $rivi['kayttajaid'];
    }

    public static function authenticate($nimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));

        $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana'],
                'admin' => $rivi['admin']
            ));

            return $kayttaja;
        } else {
            return null;
        }
    }

    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Käyttäjänimi ei voi olla tyhjä';
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen täytyy olla vähintään kahden merkin pituinen';
        }
        if (strlen($this->nimi) > 120) {
            $errors[] = 'Nimi voi olla enintään 120 merkkiä pitkä.';
        }

        return $errors;
    }

    public function validate_uniikkius() {
        $errors = array();

        if ($this->findUsernameStrict($this->nimi)) {
            $errors[] = 'Käyttäjänimi on jo käytössä';
        }

        return $errors;
    }

    public function validate_lempivari() {
        $errors = array();

        if (strlen($this->lempivari) > 20) {
            $errors[] = 'Lempivärin maksimipituus on 20';
        }

        return $errors;
    }

    public function validate_esittelyteksti() {
        $errors = array();

        if (strlen($this->esittelyteksti) > 300) {
            $errors[] = 'Esittelytekstin maksimipituus on 300 merkkiä';
        }

        return $errors;
    }

    public function validate_salasana() {
        $errors = array();

        if ($this->salasana == '' || $this->salasana == null || strlen($this->salasana) < 6) {
            $errors[] = 'Salasanan täytyy olla vähintään kuusi merkkiä pitkä';
        } else if (strlen($this->salasana) > 50) {
            $errors[] = 'Salasanan maksimipituus on 50 merkkiä';
        }

        return $errors;
    }

    public function paivita() {
        $query = DB::connection()->prepare('UPDATE Kayttaja SET nimi = :nimi, lempivari = :lempivari, esittelyteksti = :esittelyteksti WHERE kayttajaid = :kayttajaid RETURNING kayttajaid');

        $query->execute(array('nimi' => $this->nimi, 'lempivari' => $this->lempivari, 'esittelyteksti' => $this->esittelyteksti, 'kayttajaid' => $this->kayttajaId));

        $rivi = $query->fetch();

        $this->kayttajaId = $rivi['kayttajaid'];
    }

    public function poista() {
        $tagayspoisto = DB::connection()->prepare('DELETE FROM Tagays WHERE viestiid IN ('
                . 'SELECT viestiid FROM Viesti WHERE kirjoittajaid = :kayttajaid)');
        $tagayspoisto->execute(array('kayttajaid' => $this->kayttajaId));
        $viestipoisto = DB::connection()->prepare('DELETE FROM Viesti WHERE kirjoittajaid = :kayttajaid');
        $viestipoisto->execute(array('kayttajaid' => $this->kayttajaId));
        $kayttajapoisto = DB::connection()->prepare('DELETE FROM Kayttaja WHERE kayttajaid = :kayttajaid');
        $kayttajapoisto->execute(array('kayttajaid' => $this->kayttajaId));
    }

}
