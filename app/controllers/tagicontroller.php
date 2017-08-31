<?php

class TagiController extends BaseController {
    
    public static function naytaTaginViestit($tagiId) {
        self::check_logged_in();
        $viestit = Viesti::viestitTietyllaTagilla($tagiId);
        $tagi = Tagi::idEtsinta($tagiId);
        
        View::make('tagi/tagit.html', array('viestit' => $viestit, 'tamatagi' => $tagi));
    }
}


