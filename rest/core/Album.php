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
        $rdi = new RecursiveDirectoryIterator($this->path, FilesystemIterator::SKIP_DOTS);
        $ritit = new RecursiveIteratorIterator($rdi, RecursiveIteratorIterator::SELF_FIRST); 
        $r = array(); 
        $childrenCount = 0;
        $parentCount = 0;

        foreach ($ritit as $splFileInfo) {
            
            $parent = '#';

            for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
               $parent = $this->simpleChar($ritit->getSubIterator($depth)->current()->getFilename());
            }

            if($splFileInfo->isDir()){

                $id = $this->simpleChar($splFileInfo->getFilename());
                if($parent == $id){
                    $parent = '#';
                }

                if($ritit->getDepth() > 1){
                    $depth = $ritit->getDepth() - 1;
                    $parent = $ritit->getSubIterator($depth)->current()->getFilename();
                    $parent = $this->simpleChar($parent);
                }

                $r[] = array(
                        'id'=> $id,
                        'type' => 'directory',
                        'text' => $splFileInfo->getFilename(),
                        'parent' => $parent,
                        'path'=> $splFileInfo->getPathname(),
                        'teste'=> $ritit->getDepth() > 1 ? "é maior: tamanho real é {$ritit->getDepth()}" : false
                    );
                $parentMusic = $id;

            }else{

                if($splFileInfo->getExtension() != 'mp3')
                    continue;

                $r[] = array(
                    'id'=> "children_{$childrenCount}",
                    'type' => 'file',
                    'text' => $splFileInfo->getFilename(),
                    'parent' => $parentMusic,
                    'icon'=>'glyphicon glyphicon-music',
                    'a_attr'=> array('href'=> $splFileInfo->getPathname()),
                    'path'=> $parent
                );
                $childrenCount++;
            }
        }
        return $r;
    }

    protected function simpleChar($string) {
        return strtolower(preg_replace( '/[)(\/`^.~\'"\]\[\s#-]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string)));
    }
}
?>
