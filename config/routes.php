<?php

$routes->get('/', function() {
    YleisController::etusivu();
});

$routes->get('/kayttajat/:kayttajaId', function($kayttajaId) {
    KayttajaController::kayttaja($kayttajaId);
});

$routes->get('/haku', function() {
    $hakusana = $_REQUEST['name'];
    YleisController::hakusivu($hakusana);
});

$routes->get('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId) {
    KayttajaController::tietojenMuokkaus($kayttajaId);
});

$routes->post('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId){
    KayttajaController::update($kayttajaId);
});

$routes->get('/alueet/:keskustelualueId', function($keskustelualueId) {
    YleisController::viestisivu($keskustelualueId);
});

$routes->get('/hiekkalaatikko', function() {
    YleisController::sandbox();
});

$routes->get('/alueet', function(){
    KeskustelualueController::etusivu();   
});

$routes->post('/alueet', function() {
    KeskustelualueController::store();
});

$routes->get('/hiekkalaatikko', function() {
    YleisController::sandbox();
});

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

$routes->get('/alueet/:keskustelualueId/muokkaus', function($keskustelualueId){
    KeskustelualueController::tietojenmuokkaus($keskustelualueId);
});

$routes->post('/alueet/:keskustelualueId/muokkaus', function($keskustelualueId) {
    KeskustelualueController::update($keskustelualueId);
});

$routes->post('/alueet/:keskustelualueId/poista', function($keskustelualueId) {
    KeskustelualueController::poista($keskustelualueId);
});

