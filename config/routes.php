<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/kayttajasivu', function() {
    HelloWorldController::kayttajasivu();
});

$routes->get('/hakusivu', function() {
    HelloWorldController::hakusivu();
});

$routes->get('/kirjautuminen', function() {
    HelloWorldController::kirjautuminen();
});

$routes->get('/tietojenmuokkaus', function() {
    HelloWorldController::tietojenMuokkaus();
});

$routes->get('/viestisivu', function() {
    HelloWorldController::viestisivu();
});


