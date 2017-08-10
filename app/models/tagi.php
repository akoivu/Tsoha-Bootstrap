<?php

class Tagi extends BaseModel {
    
    public $id, $nimi, $viestit;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
}