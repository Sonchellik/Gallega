<?php
class Hash{

	public static function make($contraseña){//, $salt=''){
		//return hash('sha256', $string . $salt);
		$options = ['cost'=>12];
		return password_hash($contraseña, PASSWORD_DEFAULT, $options);
	}

	// public static function salt($length){
	// 	return mcrypt_create_iv($length);
	// }

	public static function unique(){
		return self::make(uniqid());
	}
}