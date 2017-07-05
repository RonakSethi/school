<?php
define('FACEBOOK_VENDOR_PATH',APP.'Vendor'.DS.'Facebook'.DS);
class FacbeookAutoload{
	
	static $loader;
	const APP_PATH = FACEBOOK_VENDOR_PATH;
	
	public static function loadClass($class)
	{
           if(self::findFile($class)){
			    return true;
           }
        
	}
	public static function loadNameSpace($class)
	{
           if(self::findNameSpaceFile($class)){
			    return true;
           }
        
	}
	
	public static  function getLoader()
	{
		$instance = new FacbeookAutoload();
		spl_autoload_register(array($instance, 'loadClass'));
	}
	 public  static function getNameSpaceLoader()
	{
		$instance = new FacbeookAutoload();
		spl_autoload_register(array($instance, 'loadNameSpace'), true, true);
	}
	
	public static function  getAutoLoadFolderList()
	{
		return array('Model','Helper');
	}
	public static function  getAutoLoadNameSpace()
	{
		return array('Vendor'=>FACEBOOK_VENDOR_PATH);
	}
	
	public static function findFile($file)
	{
		$prefix = self::APP_PATH;
		
		$ext = '.php';
		$pathList= self::getAutoLoadFolderList();
		$fileName = self::APP_PATH.DS.$file.$ext;
		if(file_exists($fileName)){
				include $fileName;
		 }
		
		
	}
	public static  function findNameSpaceFile($class)
	{
		
		if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }
      
        if (false !== $pos = strrpos($class, '\\')) {
           
            $classPath = strtr(substr($class, 0, $pos), '\\', DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            $className = substr($class, $pos + 1);
        }else{
        	$className = $class;
        }
		
		$ext = '.php';
		$pathList= self::getAutoLoadNameSpace();
		
		foreach($pathList as $path){
		    $fileName = $path.$className.$ext;
			echo $fileName .'<br>';
			if(file_exists($fileName)){
				include $fileName;
			}
		}
		
	}
}
FacbeookAutoload::getLoader();
?>