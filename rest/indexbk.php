<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim(array(
        'mode' => 'development',
        'templates.path' => './templates'
    )
);

//$app->response()->header('Content-Type', 'application/json;charset=utf-8');

class Album
{
	public static $musics = array();
	public static $key = 0;
}

function showFiles($local) 
{
    if (!$local) { return false; }
    
    if (!is_dir($local)) {
    	if(preg_match('/.+(mp3|wav)$/', $local))
    		Album::$musics[Album::$key][] = array('type'=> 'music', 'description'=>$local);
    } else {
        $dir = opendir($local);

        while ($file = readdir($dir)) {
            if ($file != '.' && $file != '..' && $file != '.htaccess') {
            	Album::$musics[Album::$key]['directory'] = basename($local);
                showFiles(("{$local}/{$file}"));
                unset($file);
            }
        }
        Album::$key++;
        
        closedir($dir);
        unset($dir);
    }
    return array(Album::$musics);
}

$app->get('/musics', function() use ($app) {

    $response = $app->response();
    $response['Content-Type'] = 'application/json';
    $response->body(json_encode( showFiles('./mus')));
});

$app->run();