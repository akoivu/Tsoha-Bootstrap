<?php

class Viesti extends BaseModel {
    
    public $viestiId, $kirjoittajaId, $keskustelualueId, $sisalto, $lahetysaika, $tagit;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Viesti');
        
        $query->execute();
        $rivit = $query->fetchAll();
        
        $viestit = array();
        
        foreach ($rivit as $rivi) {
            $viestit[] = new Viesti(array(
                'viestiId' => $rivi['viestiid'],
                'kirjoittajaId' => $rivi['kirjoittajaid'],
                'lahetysaika' => $rivi['lahetysaika'],
                'keskustelualueId' => $rivi['keskustelualueid'],
                'sisalto' => $rivi['sisalto']
            ));
        }
        
        return $viestit;
    }
    
    public static function findId($viestiId) {
        $query = DB::connection()->prepare('SELECT * FROM Viesti WHERE viestiid = :viestiid LIMIT 1');
        $query->execute(array('viestiid' => $viestiId));
        
        $rivi = $query->fetch();
        
        if($rivi) {
            $viesti = new Viesti(array(
                'viestiId' => $rivi['viestiid'],
                'kirjoittajaId' => $rivi['kirjoittajaid'],
                'lahetysaika' => $rivi['lahetysaika'],
                'keskustelualueId' => $rivi['keskustelualueid'],
                'sisalto' => $rivi['sisalto']
            ));
            
            return $viesti;
        }
        
        return null;
    }
    
    public static function findMessage($sisalto) {
        $query = DB::connection()->prepare('SELECT * FROM Viesti WHERE sisalto LIKE ?');
        $params = array('%' . $sisalto . '%');
        $query->execute($params);
        
        $rivit = $query->fetchAll();
        
        $viestit = array();
        
        foreach ($rivit as $rivi) {
            $viestit[] = new Viesti(array(
                'viestiId' => $rivi['viestiid'],
                'kirjoittajaId' => $rivi['kirjoittajaid'],
                'lahetysaika' => $rivi['lahetysaika'],
                'keskustelualueId' => $rivi['keskustelualueid'],
                'sisalto' => $rivi['sisalto']
            ));
        }
        
        return $viestit;
    }
    
    public static function findMessageByKayttaja($id) {
        $query = DB::connection()->prepare('SELECT * FROM Viesti WHERE kirjoittajaid = :kayttajaId');
        
        $query->execute(array('kayttajaId' => $id));
        
        $rivit = $query->fetchAll();
        
        $viestit = array();
        
        foreach ($rivit as $rivi) {
            $viestit[] = new Viesti(array(
                'viestiId' => $rivi['viestiid'],
                'kirjoittajaId' => $rivi['kirjoittajaid'],
                'lahetysaika' => $rivi['lahetysaika'],
                'keskustelualueId' => $rivi['keskustelualueid'],
                'sisalto' => $rivi['sisalto']
            ));
        }
        
        return $viestit;
    }
    
    public static function findMessageByKeskustelualue($keskustelualueId) {
        $query = DB::connection()->prepare('SELECT * FROM Viesti WHERE keskustelualueid = :keskustelualueId');
        $query->execute(array('keskustelualueId' => $keskustelualueId));
        
        $rivit = $query->fetchAll();
        
        $viestit = array();
        
        foreach ($rivit as $rivi) {
            $viestit[] = new Viesti(array(
                'viestiId' => $rivi['viestiid'],
                'kirjoittajaId' => $rivi['kirjoittajaid'],
                'lahetysaika' => $rivi['lahetysaika'],
                'keskustelualueId' => $rivi['keskustelualueid'],
                'sisalto' => $rivi['sisalto']
            ));
        }
        
        return $viestit;
    }
}

