<?php

class Keskustelualue extends BaseModel {

    public $keskustelualueId, $nimi, $maara;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi');
    }

    public static function listaaKaikki() {
        $query = DB::connection()->prepare('SELECT * FROM Keskustelualue');

        $query->execute();
        $rivit = $query->fetchAll();

        $keskustelualueet = array();

        foreach ($rivit as $rivi) {
            $maara = Keskustelualue::maara($rivi['keskustelualueid']);
            $keskustelualueet[] = new Keskustelualue(array(
                'keskustelualueId' => $rivi['keskustelualueid'],
                'nimi' => $rivi['nimi'],
                'maara' => $maara
            ));
        }

        return $keskustelualueet;
    }

    public static function idEtsinta($keskustelualueId) {
        $query = DB::connection()->prepare('SELECT * FROM Keskustelualue WHERE keskustelualueid = :keskustelualueId LIMIT 1');
        $query->execute(array('keskustelualueId' => $keskustelualueId));

        $rivi = $query->fetch();

        if ($rivi) {
            $maara = Keskustelualue::maara($rivi['keskustelualueid']);

            $keskustelualue = new Keskustelualue(array(
                'keskustelualueId' => $rivi['keskustelualueid'],
                'nimi' => $rivi['nimi'],
                'maara' => $maara
            ));

            return $keskustelualue;
        }

        return null;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Keskustelualue (nimi) VALUES (:nimi) RETURNING keskustelualueid');
        $query->execute(array('nimi' => $this->nimi));

        $row = $query->fetch();

        $this->keskustelualueId = $row['keskustelualueid'];
    }

    public static function maara($id) {
        $query = DB::connection()->prepare('SELECT COUNT(*) FROM Viesti WHERE keskustelualueid = :id');

        $query->execute(array('id' => $id));
        $maara = $query->fetch();

        return $maara['count'];
    }

    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Keskustelualueella tulee olla nimi.';
        }
        if (strlen($this->nimi) < 2) {
            $errors[] = 'Nimen täytyy olla vähintään kahden merkin pituinen.';
        }
        if(strlen($this->nimi) > 40) {
            $errors[] = 'Nimi voi olla enintään 40 merkkiä pitkä.';
        }

        return $errors;
    }

    public function paivita() {
        $query = DB::connection()->prepare('UPDATE Keskustelualue SET nimi = :nimi WHERE keskustelualueid = :keskustelualueid');
        
        $query->execute(array('nimi' => $this->nimi, 'keskustelualueid' => $this->keskustelualueId));
    }
    
    public function poista() {
        $tagayspoisto = DB::connection()->prepare('DELETE FROM Tagays WHERE viestiid IN ('
                . 'SELECT viestiid FROM Viesti WHERE keskustelualueid = :keskustelualueid)');
        $tagayspoisto->execute(array('keskustelualueid' => $this->keskustelualueId));
        $viestipoisto = DB::connection()->prepare('DELETE FROM Viesti WHERE keskustelualueid = :keskustelualueid');
        $viestipoisto->execute(array('keskustelualueid' => $this->keskustelualueId));
        $query = DB::connection()->prepare('DELETE FROM Keskustelualue WHERE keskustelualueid = :keskustelualueid');
        $query->execute(array('keskustelualueid' => $this->keskustelualueId));
    }
}
