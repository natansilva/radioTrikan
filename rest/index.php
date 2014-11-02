<?php
require_once 'vendor/autoload.php';
require_once 'core/Album.php';
require_once 'core/cache.class.php';

$app = new \Slim\Slim(array(
        'mode' => 'development',
        'templates.path' => './templates'
    )
);

$app->get('/musics/', function() use ($app) {

    $response = $app->response();
    $response['Content-Type'] = 'application/json';

    $c = new Cache();
    $nameCache = 'newcache';

    if($c->isCached($nameCache)){
        $result = $c->retrieve($nameCache);
        $response->body($result);
    }else{
    	$album = new Album('./mus');
    	$recursive = json_encode($album->showFiles());
		
    	$c->store($nameCache, $recursive);
        $response->body($recursive);	
    }
});

$app->get('/download/:music', function($musica) {
    $arquivo = $musica;
    switch(strtolower(substr(strrchr(basename($arquivo),"."),1))){
        case "mp3": $tipo="audio/mpeg"; break;
    }

     header("Content-Type: ".$tipo);
     header("Content-Length: ".filesize($arquivo));
     header("Content-Disposition: attachment; filename=".basename($arquivo));
     readfile($arquivo);
     exit;
})->conditions(array('music' => '.+'));;

$app->run();