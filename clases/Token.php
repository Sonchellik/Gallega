<?php
class Token{
	public static function generate(){
		return Session::put(Config::get('session/token_name'), md5(uniqid(rand(), true)));
		// $token = Config::get('session/token_name');
		// return Session::put($token, hash_hmac('sha256', $token, uniqid(rand())));
	}

	public static function check($token){
		$tokenName = Config::get('session/token_name');
		
		 if(Session::exists($tokenName)&& Token::generate() === Session::get($tokenName)){ 
		 	Session::delete($tokenName);
		 	return true;
		}else{
		return false;}
	}
}