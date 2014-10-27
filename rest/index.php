<?php
require_once 'vendor/autoload.php';
require_once 'core/Album.php';

$app = new \Slim\Slim(array(
        'mode' => 'development',
        'templates.path' => './templates'
    )
);


$app->get('/musics/', function() use ($app) {
    $response = $app->response();
    //$response['Content-Type'] = 'application/json';
    
    $album = new Album('./mus');
    $albuns = array();    

    $album->showFiles();
    
    $response->body();
});

$app->run();