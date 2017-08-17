<?php

$routes->get('/', function() {
    HelloWorldController::etusivu();
});

$routes->get('/kayttajat/:kayttajaId', function($kayttajaId) {
    HelloWorldController::kayttaja($kayttajaId);
});

$routes->get('/haku', function() {
    $hakusana = $_REQUEST['name'];
    HelloWorldController::hakusivu($hakusana);
});

$routes->get('/kirjautuminen', function() {
    HelloWorldController::kirjautuminen();
});

$routes->get('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId) {
    KayttajaController::tietojenMuokkaus($kayttajaId);
});

$routes->post('/kayttajat/:kayttajaId/muokkaus', function($kayttajaId){
    KayttajaController::update($kayttajaId);
});

$routes->get('/alueet/:keskustelualueId', function($keskustelualueId) {
    HelloWorldController::viestisivu($keskustelualueId);
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/alueet', function(){
    KeskustelualueController::etusivu();   
});

$routes->post('/alueet', function() {
    KeskustelualueController::store();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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
