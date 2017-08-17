<?php

class KeskustelualueController extends BaseController {

    public static function etusivu() {
        $keskustelualueet = Keskustelualue::all();
        View::make('alueet.html', array('keskustelualueet' => $keskustelualueet));
    }

    public static function store() {
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
            View::make('alueet.html', array('errors' => $errors, 'attributes' => $attributes, 'keskustelualueet' => $keskustelualueet));
        }
    }

}
