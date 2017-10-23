<?php
class Usuario{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;		

	public function __construct($usuario = null){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('recuerda/cookie_name');

		if(!$usuario){ 
			if(Session::exists($this->_sessionName)){
				$usuario = Session::get($this->_sessionName);
				if($this->find($usuario)){
					$this->_isLoggedIn = true;
				}
			}
		}else{
			$this->find($usuario);
			$this->_isLoggedIn = true;//sin esto non funciona en páxina de perfil
		}
	}

	public function crear($fields = array()){
		 if(!$this->_db->insert('usuarios', $fields)){
		 	throw new Exception('No se ha podido crear la cuenta');
		 }
		
	}

	public function data(){
		return $this->_data;
	}

	public function find($usuario = null){
		if($usuario){ 
			$field = (is_numeric($usuario)) ? "idUsuario" : "email";
			$data = $this->_db->get('usuarios', array($field, '=', $usuario));

			if($data->count()){
				$this->_data = $data->first(); 
				return true;
			}
		}
		return false;
	}

	public function login($email = null, $contraseña = null, $recuerda = null){

		if(!$email && !$contraseña && $this->exists()){ 
			Session::put($this->_sessionName, $this->data()->id);
			
		}
		else{
		    $usuario = $this->find($email); 
			if($usuario){ 
				 if(password_verify($contraseña,$this->data()->contraseña)){ 
					Session::put($this->_sessionName, $this->data()->idUsuario);
					if($recuerda){
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('sesionUsuario', array('idUsuario', '=', $this->data()->idUsuario));
						if(!$hashCheck->count()){
							$this->_db->insert('sesionUsuario', array(
								'idUsuario' => $this->data()->idUsuario,
								'hash' => $hash));
						}else{
							$hash = $hashCheck->first()->hash;
						}
						Cookie::put($this->_cookieName, $hash,Config::get('recuerda/cookie_expiry'));
					 } 

				return true;	
				} 
				
			}
				
		}return false;
	}

	public function actualizar($fields = array(), $id = null){

		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->idUsuario;
		}
		if(!$this->_db->update('usuarios', $id, $fields)){ 
			throw new Exception('Hubo un problema al actualizar.');
		}
	}



	public function hasPermission($key){
		$grupo = $this->_db->get('grupos', array('id', '=', $this->data()->grupo));

		if($grupo->count()){
			$permisos = json_decode($grupo->first()->permisos,true);

			if($permisos[$key] === true){
				return true;
			}
		}
		return false;
	}

	public function exists(){
		return (!empty($this->data)) ? true : false;
	}

	public function logout(){
		$this->_db->delete('sesionUsuario', array('idUsuario', '=', $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}

}