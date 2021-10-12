<?php
class helpFactory
{
    //protected $classname;
    public function __construct()
    {
        
    }
    public static function activate($class,$parameters=null)
    {
        $namepath=explode("/", $class);
        $classname=array_pop($namepath);//[1];//lcfirst($namepath[1]);
        $filepath=$_SERVER['DOCUMENT_ROOT']."/classes/".$class.".php";
        if (file_exists($filepath)) {
            include_once $filepath; 
            $obj=new $classname($parameters);
            return $obj;
        } else {
            echo "Не найден ",$filepath;
        }  
      
    }
}    
?>
