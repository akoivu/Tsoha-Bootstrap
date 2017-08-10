<?php

class Keskustelualue extends BaseModel {
    
    public $keskustelualueId, $nimi, $maara;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
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
    
    public static function findId($keskustelualueId) {
        $query = DB::connection()->prepare('SELECT * FROM Keskustelualue WHERE keskustelualueid = :keskustelualueId LIMIT 1');
        $query->execute(array('keskustelualueId' => $keskustelualueId));
        
        $rivi = $query->fetch();
        
        if($rivi) {
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
    
    public function save() {
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
}
