<?php

class Tagi extends BaseModel {
    
    public $id, $nimi, $viestit;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tagi');
        $query->execute();
        $rivit = $query->fetchAll();
        
        $tagit = array();
        
        foreach ($rivit as $rivi) {
            $tagit[] = new Tagi(array(
                'id' => $rivi['tagiid'],
                'nimi' => $rivi['nimi']
            ));        
        }
        
        return $tagit;
    }
    
    public static function findName($nimi) {
        $query = DB::connection()->prepare('SELECT * FROM Tagi WHERE nimi LIKE ?');
        $params = array('%' . $nimi . '%');
        $query->execute($params);
        
        $rivit = $query->fetchAll();
        
        $tagit = array();
        
        foreach ($rivit as $rivi) {
            $tagit[] = new Tagi(array(
                'id' => $rivi['tagiid'],
                'nimi' => $rivi['nimi']
            ));        
        }
        
        return $tagit;
    }
}