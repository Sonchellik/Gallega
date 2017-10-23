<?php
/**PARA ACCEDER A TODOS LOS ELEMENTOS GLOBALES DE CONFIGURACIÓN DE init.php **/
class Config{
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['config'];
			$path = explode('/', $path);

            //seleccionamos el elemento del array deseado     
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}