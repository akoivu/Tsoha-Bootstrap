<?php

class Viesti extends BaseModel {

    public $viestiId, $kirjoittajaId, $keskustelualueId, $sisalto, $lahetysaika, $tagit, $kirjoittaja, $keskustelualue;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_sisalto');
    }

    public static function listaaKaikki() {
        $query = DB::connection()->prepare('SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'ORDER BY v.lahetysaika');

        $query->execute();
        $rivit = $query->fetchAll();

        $viestit = Viesti::kasitteleRivit($rivit);

        return $viestit;
    }

    public static function idEtsinta($viestiId) {
        $query = DB::connection()->prepare('SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'WHERE v.viestiid = :viestiid');
        $query->execute(array('viestiid' => $viestiId));

        $rivit = $query->fetchAll();

        if (!isset($rivit)) {
            return null;
        }

        $viestit = Viesti::kasitteleRivit($rivit);
        foreach ($viestit as $viesti) {
            $haluttu = $viesti;
        }

        return $haluttu;
    }

    public static function viestiEtsinta($sisalto) {
        $query = DB::connection()->prepare('SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi, ka.nimi AS ka_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'LEFT JOIN Keskustelualue ka ON ka.keskustelualueid = v.keskustelualueid '
                . 'WHERE sisalto LIKE ? '
                . 'ORDER BY v.lahetysaika');
        $params = array('%' . $sisalto . '%');
        $query->execute($params);

        $rivit = $query->fetchAll();

        $viestit = Viesti::kasitteleRivit($rivit);

        return $viestit;
    }

    public static function etsiKayttajanViestit($kayttajaId) {
        $query = DB::connection()->prepare('SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi, ka.nimi AS ka_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'LEFT JOIN Keskustelualue ka ON ka.keskustelualueid = v.keskustelualueid '
                . 'WHERE k.kayttajaid = :kayttajaid '
                . 'ORDER BY v.lahetysaika');

        $query->execute(array('kayttajaid' => $kayttajaId));

        $rivit = $query->fetchAll();

        $viestit = Viesti::kasitteleRivit($rivit);

        return $viestit;
    }

    public static function etsiKeskustelualueenViestit($keskustelualueId, $tagit) {
        $kysely = 'SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'WHERE v.keskustelualueid = :keskustelualueid ';
        $parametrit = array('keskustelualueid' => $keskustelualueId);
        if (isset($tagit)) {
            $kysely .= ' AND v.viestiid NOT IN ('
                    . 'SELECT v.viestiid FROM Viesti v '
                    . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                    . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid WHERE ';
            for ($x = 0; $x < count($tagit); $x++) {
                $kysely .= 't.tagiid = :tagiid' . $x . ' OR ';
                $lisays = 'tagiid' . $x;
                $parametrit[$lisays] = $tagit[$x];
            }
            $kysely = OletusController::poistaViimeinenOR($kysely);
            $kysely .= ') ';
        }
        $kysely .= 'ORDER BY v.lahetysaika';
        $query = DB::connection()->prepare($kysely);
        $query->execute($parametrit);
        $rivit = $query->fetchAll();
        $viestit = Viesti::kasitteleRivit($rivit);
        return $viestit;
    }

    public static function viestitTietyllaTagilla($tagiId) {
        $query = DB::connection()->prepare('SELECT v.viestiid, v.kirjoittajaid, v.lahetysaika, v.keskustelualueid, v.sisalto, k.nimi, t.tagiid, t.nimi AS tagi_nimi, ka.nimi AS ka_nimi FROM Viesti v '
                . 'LEFT JOIN Tagays ta ON ta.viestiid = v.viestiid '
                . 'LEFT JOIN Tagi t ON ta.tagiid = t.tagiid '
                . 'LEFT JOIN Kayttaja k ON k.kayttajaid = v.kirjoittajaid '
                . 'LEFT JOIN Keskustelualue ka ON ka.keskustelualueid = v.keskustelualueid '
                . 'WHERE t.tagiid = :tagiid '
                . 'ORDER BY v.lahetysaika');

        $query->execute(array('tagiid' => $tagiId));

        $rivit = $query->fetchAll();

        $viestit = Viesti::kasitteleRivit($rivit);

        return $viestit;
    }

    public static function kasitteleRivit($rivit) {
        $viestit = array();
        foreach ($rivit as $rivi) {
            $id = $rivi['viestiid'];
            if (!isset($viestit[$id])) {
                $viestit[$rivi['viestiid']] = Viesti::luoViestiParametreilla($rivi);
            } else {
                $tagi = new Tagi(array('nimi' => $rivi['tagi_nimi'], 'tagiId' => $rivi['tagiid']));
                $viestit[$id]->tagit[] = $tagi;
            }

            if (isset($rivi['ka_nimi'])) {
                $viestit[$id]->keskustelualue = $rivi['ka_nimi'];
            }
        }

        return $viestit;
    }

    public static function luoViestiParametreilla($parametrit) {
        if (isset($parametrit['tagiid'])) {
            $tagit = array(new Tagi(array('nimi' => $parametrit['tagi_nimi'], 'tagiId' => $parametrit['tagiid'])));
        } else {
            $tagit = null;
        }
        return new Viesti(array(
            'viestiId' => $parametrit['viestiid'],
            'kirjoittajaId' => $parametrit['kirjoittajaid'],
            'lahetysaika' => $parametrit['lahetysaika'],
            'keskustelualueId' => $parametrit['keskustelualueid'],
            'sisalto' => $parametrit['sisalto'],
            'kirjoittaja' => $parametrit['nimi'],
            'tagit' => $tagit
        ));
    }

    public function validate_sisalto() {
        $errors = array();

        if ($this->sisalto == null || $this->sisalto == '') {
            $errors[] = 'Viesti ei voi olla tyhjä.';
        }
        if (strlen($this->sisalto) > 300) {
            $errors[] = 'Viesti voi olla enintään 300 merkkiä pitkä.';
        }

        return $errors;
    }

    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Viesti (sisalto, kirjoittajaid, keskustelualueid, lahetysaika) VALUES(:sisalto, :kayttajaid, :keskustelualueid, :lahetysaika) RETURNING viestiid');
        $query->execute(array('sisalto' => $this->sisalto, 'kayttajaid' => $this->kirjoittajaId, 'keskustelualueid' => $this->keskustelualueId, 'lahetysaika' => $this->lahetysaika));

        $rivi = $query->fetch();

        $this->viestiId = $rivi['viestiid'];
    }

    public function paivita() {
        $query = DB::connection()->prepare('UPDATE Viesti SET sisalto = :sisalto WHERE viestiid = :viestiid RETURNING viestiid');

        $query->execute(array('sisalto' => $this->sisalto, 'viestiid' => $this->viestiId));
        $rivi = $query->fetch();

        if (isset($this->tagit)) {
            $poisto = DB::connection()->prepare('DELETE FROM Tagays WHERE viestiid = :viestiid');
            $poisto->execute(array('viestiid' => $this->viestiId));
            foreach ($this->tagit as $tagi) {
                Viesti::uusiTagays($tagi, $this->viestiId);
            }
        }

        $this->viestiId = $rivi['viestiid'];
    }

    public static function uusiTagays($tagi, $viestiId) {
        $query = DB::connection()->prepare('INSERT INTO Tagays (viestiid, tagiid) VALUES (:viestiid, :tagiid)');
        $query->execute(array('viestiid' => $viestiId, 'tagiid' => $tagi));
    }

    public function poista() {
        $tagayspoisto = DB::connection()->prepare('DELETE FROM Tagays WHERE viestiid = :viestiid');
        $tagayspoisto->execute(array('viestiid' => $this->viestiId));
        $viestipoisto = DB::connection()->prepare('DELETE FROM Viesti WHERE viestiid = :viestiid');
        $viestipoisto->execute(array('viestiid' => $this->viestiId));
    }

}
