<?php

$routes->get('/', function() {
    HelloWorldController::index();
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
    HelloWorldController::tietojenMuokkaus($kayttajaId);
});

$routes->get('/alueet/:keskustelualueId', function($keskustelualueId) {
    HelloWorldController::viestisivu($keskustelualueId);
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->post('/alueet', function() {
    HelloWorldController::store();
});


