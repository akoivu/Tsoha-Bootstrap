<?php

class Kayttaja extends BaseModel {

    public $kayttajaId, $nimi, $liittymispaiva, $lempivari, $esittelyteksti, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
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
                'salasana' => $rivi['salasana']
            ));
        }
        
        return $kayttajat;
    }
    
    public static function findId($kayttajaId) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaId LIMIT 1');
        $query->execute(array('kayttajaId' => $kayttajaId));
        
        $rivi = $query->fetch();
        
        if($rivi) {
            $kayttaja = new Kayttaja(array(
                'kayttajaId' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi'],
                'liittymispaiva' => $rivi['liittymispaiva'],
                'lempivari' => $rivi['lempivari'],
                'esittelyteksti' => $rivi['esittelyteksti'],
                'salasana' => $rivi['salasana']
            ));
            
            return $kayttaja;
        }
        
        return null;
    }

    public static function findUserName($nimi) {
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
                'salasana' => $rivi['salasana']
            ));
        }
        
        return $kayttajat;
    }
    
}
