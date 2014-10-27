<?php 
class Album
{
    public static $musics = array();
    public static $category;
    public static $key = 0;
    public static $parent_id = 0;
    public static $childre_id = 0;
    public static $parent_last;

    public $path;

    public function __construct($path){
        $this->path = $path;
    }

    function showFiles(){
        $path = $this->path;

        $directory = new \RecursiveDirectoryIterator($path, \FilesystemIterator::FOLLOW_SYMLINKS);
        $filter = new \RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) {
            // Skip hidden files and directories.
            if ($current->getFilename()[0] === '..') {
                return FALSE;
            }
            return $iterator;
        });

        $iterator = new \RecursiveIteratorIterator($filter);
        $files = array();
        
        foreach ($iterator as $info) {

            $files[] = array(
                'name' => $info->isDir() ? $info->getPath() : $info->getPathname(),
                'type' => $info->isDir() ? 'dir' : 'file'
            );    
        }

        foreach ($files as $file) {
            echo "{$file['type']}: {$file['name']} <br />";
        }
        
        die();
        //ksort(Album::$musics);
        
        //return Album::$musics;
    }

    protected function simpleChar($string) {
        return strtolower(preg_replace( '/[`^~\'"\s]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string)));
    }

    function exists($key1, $key2)
    {
        if ($key1 == $key2){
            return true;
        }else{
            return false;
        }
    }
    
}
?>
