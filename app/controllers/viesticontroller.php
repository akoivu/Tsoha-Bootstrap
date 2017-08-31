<?php

class ViestiController extends BaseController {

    public static function viestiSivuFiltterilla($keskustelualueId) {
        self::check_logged_in();
        $parametrit = $_POST;

        if (isset($parametrit['eitagit'])) {
            $poisjaavat = $parametrit['eitagit'];
        } else {
            $poisjaavat = null;
        }

        $viestit = Viesti::etsiKeskustelualueenViestit($keskustelualueId, $poisjaavat);
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        $tagit = Tagi::listaaKaikki();
        View::make('viesti/viestisivu.html', array('viestit' => $viestit, 'keskustelualue' => $keskustelualue, 'tagit' => $tagit));
    }

    public static function viestisivu($keskustelualueId) {
        self::check_logged_in();
        $viestit = Viesti::etsiKeskustelualueenViestit($keskustelualueId, null);
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        $tagit = Tagi::listaaKaikki();
        View::make('viesti/viestisivu.html', array('viestit' => $viestit, 'keskustelualue' => $keskustelualue, 'tagit' => $tagit));
    }

    public static function uusiViesti($keskustelualueId) {
        self::check_logged_in();

        $viestit = Viesti::etsiKeskustelualueenViestit($keskustelualueId, null);
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        $tagit = Tagi::listaaKaikki();

        $rivi = $_POST;

        $attribuutit = array(
            'sisalto' => $rivi['sisalto'],
            'keskustelualueId' => $keskustelualueId,
            'kirjoittajaId' => $rivi['kayttajaId'],
            'lahetysaika' => date('d-m-Y H:i:s')
        );

        $viesti = new Viesti($attribuutit);
        $virheet = $viesti->errors();

        if (count($virheet) > 0) {
            View::make('viesti/viestisivu.html', array('info' => $viestit, 'keskustelualue' => $keskustelualue, 'tagit' => $tagit, 'virheet' => $virheet));
        } else {
            $viesti->tallenna();
            Redirect::to('/alueet/' . $keskustelualueId, array('info' => 'Uusi viesti lähetetty'));
        }
    }

    public static function muokkaaViestia($keskustelualueId, $viestiId) {
        self::check_logged_in();

        $rivi = $_POST;

        $vanha = Viesti::idEtsinta($viestiId);

        if (isset($_POST['tagit'])) {
            $viestiTagit = $_POST['tagit'];
        }

        $attribuutit = array(
            'viestiId' => $vanha->viestiId,
            'sisalto' => $rivi['sisalto'],
            'keskustelualueId' => $keskustelualueId,
            'kirjoittajaId' => $vanha->kirjoittajaId,
            'lahetysaika' => $vanha->lahetysaika,
            'tagit' => array()
        );

        if (isset($_POST['tagit'])) {
            foreach ($viestiTagit as $tagi) {
                $attribuutit['tagit'][] = $tagi;
                $valmiitTagit[] = $tagi;
            }
        }

        $uusi = new Viesti($attribuutit);

        $virheet = $uusi->errors();

        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        $tagit = Tagi::listaaKaikki();


        if (count($virheet) > 0) {
            View::make('viesti/viestimuokkaus.html', array('virheet' => $virheet, 'viesti' => $uusi, 'tagit' => $tagit, 'keskustelualue' => $keskustelualue, 'valmiit' => $valmiitTagit));
        } else {
            $uusi->paivita();
            Redirect::to('/alueet/' . $keskustelualueId, array('info' => 'Viestiä muokattu onnistuneesti'));
        }
    }

    public static function muokkausnakyma($keskustelualueId, $viestiId) {
        self::check_logged_in();
        $viesti = Viesti::idEtsinta($viestiId);
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        $tagit = Tagi::listaaKaikki();

        $valmiitTagit = array();

        if (isset($viesti->tagit)) {
            foreach ($viesti->tagit as $tagi) {
                $valmiitTagit[] = $tagi->tagiId;
            }
        }

        View::make('viesti/viestimuokkaus.html', array('keskustelualue' => $keskustelualue, 'viesti' => $viesti, 'tagit' => $tagit, 'valmiit' => $valmiitTagit));
    }

    public static function poista($keskustelualueId, $viestiId) {
        self::check_logged_in();
        $viesti = Viesti::idEtsinta($viestiId);

        $viesti->poista();

        Redirect::to('/alueet/' . $keskustelualueId, array('viesti' => 'Viesti on poistettu'));
    }

}
