<?php

class KeskustelualueController extends BaseController {

    public static function etusivu() {
        self::check_logged_in();
        $keskustelualueet = Keskustelualue::all();
        View::make('keskustelualue/alueet.html', array('keskustelualueet' => $keskustelualueet));
    }

    public static function store() {
        self::check_logged_in();
        $rivi = $_POST;

        $attributes = array(
            'nimi' => $rivi['nimi'],
            'maara' => 0
        );

        $keskustelualue = new Keskustelualue($attributes);

        $errors = $keskustelualue->errors();
        
        if (count($errors) == 0) {
            $keskustelualue->save();
            
            Redirect::to('/alueet/' . $keskustelualue->keskustelualueId, array('message' => 'Uusi keskustelualue on syntynyt!'));
        } else {
            $keskustelualueet = Keskustelualue::all();
            View::make('keskustelualue/alueet.html', array('errors' => $errors, 'attributes' => $attributes, 'keskustelualueet' => $keskustelualueet));
        }
    }

    public static function update($keskustelualueId) {
        
        
        $rivi = $_POST;
        
        $maara = Keskustelualue::findId($keskustelualueId)->maara;
        
        $attributes = array(
            'keskustelualueId' => $keskustelualueId,
            'nimi' => $rivi['nimi'],
            'maara' => $maara
        );
        
        $uusi = new Keskustelualue($attributes);
        
        $errors = $uusi->errors();
        
        
        if(count($errors) > 0) {
            View::make('keskustelualue/muokkaus', array('errors' => $errors));
        } else {
            $uusi->update();
            Redirect::to('/alueet', array('message' => 'Keskustelualueen muokkaaminen onnistui'));
        }
    }
    
    public static function tietojenmuokkaus($keskustelualueId) {
        $keskustelualue = Keskustelualue::findId($keskustelualueId);
        View::make('keskustelualue/muokkaus.html', array('keskustelualue' => $keskustelualue));
    }
    
    public static function poista($keskustelualueId) {
        $keskustelualue = Keskustelualue::findId($keskustelualueId);
        
        $keskustelualue->poista();
        Redirect::to('/alueet', array('message' => 'Keskustelualue poistettu'));
    }
}
