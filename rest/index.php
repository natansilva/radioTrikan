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
    $response['Content-Type'] = 'application/json';
    
    $album = new Album('./mus');
    
    $albuns = array();    

    $parent = 0;
    $children = 0;
    
    foreach($album->showFiles() as $album => $musics){
        $albuns[] = array('id'=>"parent_{$parent}", 'parent'=>'#', 'text'=>$album);
        if(is_array($musics) && count($musics)){
            foreach($musics as $music){
                $albuns[] = array(
                    'id'=>"children_{$children}", 
                    'parent'=>"parent_{$parent}", 
                    'text'=> basename($music['music']), 
                    'icon'=>'glyphicon glyphicon-music',
                    'a_attr'=> array('href'=>$music['music'])
                );
                $children++;
            }    
        }
        $parent++;
    }
    $response->body(json_encode($albuns));
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