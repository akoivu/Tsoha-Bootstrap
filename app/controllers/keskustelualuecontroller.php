<?php

class KeskustelualueController extends BaseController {

    public static function etusivu() {
        self::check_logged_in();
        $keskustelualueet = Keskustelualue::listaaKaikki();
        View::make('keskustelualue/alueet.html', array('keskustelualueet' => $keskustelualueet));
    }

    public static function uusiKeskustelualue() {
        self::check_logged_in();
        $rivi = $_POST;

        $attribuutit = array(
            'nimi' => $rivi['nimi'],
            'maara' => 0
        );

        $keskustelualue = new Keskustelualue($attribuutit);

        $virheet = $keskustelualue->errors();
        
        if (count($virheet) == 0) {
            $keskustelualue->tallenna();
            
            Redirect::to('/alueet/' . $keskustelualue->keskustelualueId, array('info' => 'Uusi keskustelualue on syntynyt!'));
        } else {
            $keskustelualueet = Keskustelualue::listaaKaikki();
            View::make('keskustelualue/alueet.html', array('virheet' => $virheet, 'attributes' => $attribuutit, 'keskustelualueet' => $keskustelualueet));
        }
    }

    public static function update($keskustelualueId) {
        self::check_logged_in();
        
        $rivi = $_POST;
        
        $maara = Keskustelualue::idEtsinta($keskustelualueId)->maara;
        
        $attribuutit = array(
            'keskustelualueId' => $keskustelualueId,
            'nimi' => $rivi['nimi'],
            'maara' => $maara
        );
        
        $uusi = new Keskustelualue($attribuutit);
        
        $virheet = $uusi->errors();
        
        
        if(count($virheet) > 0) {
            View::make('keskustelualue/muokkaus', array('virheet' => $virheet));
        } else {
            $uusi->paivita();
            Redirect::to('/alueet', array('info' => 'Keskustelualueen muokkaaminen onnistui'));
        }
    }
    
    public static function tietojenmuokkaus($keskustelualueId) {
        self::check_logged_in();
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        View::make('keskustelualue/muokkaus.html', array('keskustelualue' => $keskustelualue));
    }
    
    public static function poista($keskustelualueId) {
        self::check_logged_in();
        $keskustelualue = Keskustelualue::idEtsinta($keskustelualueId);
        
        $keskustelualue->poista();
        Redirect::to('/alueet', array('info' => 'Keskustelualue poistettu'));
    }
}
