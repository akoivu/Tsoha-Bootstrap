<?php

class Tagi extends BaseModel {
    
    public $tagiId, $nimi, $viestit;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function listaaKaikki() {
        $query = DB::connection()->prepare('SELECT * FROM Tagi');
        $query->execute();
        $rivit = $query->fetchAll();
        
        $tagit = array();
        
        foreach ($rivit as $rivi) {
            $tagit[] = new Tagi(array(
                'tagiId' => $rivi['tagiid'],
                'nimi' => $rivi['nimi']
            ));        
        }
        
        return $tagit;
    }
    
    public static function etsiNimella($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Tagi WHERE nimi LIKE ?');
        $params = array('%' . $nimi . '%');
        $query->execute($params);
        
        $rivit = $query->fetchAll();
        
        $tagit = array();
        
        foreach ($rivit as $rivi) {
            $tagit[] = new Tagi(array(
                'tagiId' => $rivi['tagiid'],
                'nimi' => $rivi['nimi']
            ));        
        }
        
        return $tagit;
    }
    
    public static function idEtsinta($tagiId) {
        $kysely = DB::connection()->prepare('SELECT * FROM Tagi WHERE tagiid = :tagiid LIMIT 1');
        $kysely->execute(array('tagiid' => $tagiId));
        
        $rivi = $kysely->fetch();
        
        if($rivi) {
            $tagi = new Tagi(array(
                'tagiId' => $rivi['tagiid'],
                'nimi' => $rivi['nimi']
            ));
            
            return $tagi;
        }
        
        return null;
    }
}