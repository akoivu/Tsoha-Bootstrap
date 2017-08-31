<?php

//OletusController-polut
$routes->get('/', function() {
    OletusController::etusivu();
});

$routes->get('/haku', function() {
    $hakusana = $_REQUEST['name'];
    OletusController::hakusivu($hakusana);
});

$routes->get('/hiekkalaatikko', function() {
    OletusController::sandbox();
});

//KayttajaController-polut
$routes->get('/login', function() {
    KayttajaController::kirjautumissivu();
}); 

$routes->post('/login', function() {
    KayttajaController::kirjautuminen();
}); 

$routes->post('/register', function() {
    KayttajaController::store();
});

$routes->post('/kayttajat/:kayttajaId/poista', function($kayttajaId) {
    KayttajaController::poista($kayttajaId);
}); 

$routes->get('/kayttajat', function() {
    KayttajaController::kayttajat();
});

$routes->get('/logout', function() {
    KayttajaController::uloskirjautuminen();
});

$routes->get('/kayttajat/:kayttajaId', function($kayttajaId) {
    KayttajaController::kayttaja($kayttajaId);
});

$routes->get('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId) {
    KayttajaController::tietojenMuokkaus($kayttajaId);
});

$routes->post('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId){
    KayttajaController::update($kayttajaId);
});

//KeskustelualueController-polut
$routes->get('/alueet/:keskustelualueId/muokkaus', function($keskustelualueId){
    KeskustelualueController::tietojenmuokkaus($keskustelualueId);
});

$routes->post('/alueet/:keskustelualueId/muokkaus', function($keskustelualueId) {
    KeskustelualueController::update($keskustelualueId);
});

$routes->post('/alueet/:keskustelualueId/poista', function($keskustelualueId) {
    KeskustelualueController::poista($keskustelualueId);
});

$routes->post('/alueet', function() {
    KeskustelualueController::uusiKeskustelualue();
});

$routes->get('/alueet', function(){
    KeskustelualueController::etusivu();   
});

//ViestiController-polut
$routes->post('/alueet/:keskustelualueId', function($keskustelualueId) {
    if($_POST['toiminto'] == 'uusi') {
        ViestiController::uusiViesti($keskustelualueId);
    } else if($_POST['toiminto'] == 'filter'){
        ViestiController::viestiSivuFiltterilla($keskustelualueId);
    }
});

$routes->get('/alueet/:keskustelualueId/:viestiId/muokkaa', function($keskustelualueId, $viestiId) {
    ViestiController::muokkausnakyma($keskustelualueId, $viestiId);
});

$routes->post('/alueet/:keskustelualueId/:viestiId/muokkaa', function($keskustelualueId, $viestiId) {
    ViestiController::muokkaaViestia($keskustelualueId, $viestiId);
});

$routes->post('/alueet/:keskustelualueId/:viestiId/poista', function($keskustelualueId, $viestiId) {
    ViestiController::poista($keskustelualueId, $viestiId);
});

$routes->get('/alueet/:keskustelualueId', function($keskustelualueId) {
    ViestiController::viestisivu($keskustelualueId);
});

$routes->get('/tagit/:tagiId', function($tagiId) {
    TagiController::naytaTaginViestit($tagiId);
});

