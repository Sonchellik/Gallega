<?php
class Validate{
	private $_passed = false,
			$_errores = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items=array()){
		foreach($items as $item=>$rules){
			foreach($rules as $rule=>$rule_value){
				$value = trim($source[$item]);
				if($rule === 'required' && empty($value)){
					$this->addError("Introduzca {$item}");
				}else if(!empty($value)){
					switch($rule){
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("Su {$item} debe tener un mínimo de {$rule_value} caracteres.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("Su {$item} debe tener un máximo de {$rule_value} caracteres.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addError("Las contraseñas no coinciden.");
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()){
								$this->addError("{$item} ya existe.");
							}
						break;
					}

				}
			}
		}
		if(empty($this->_errores)){
			$this->_passed = true;
		}
		return $this;
	}

	private function addError($error){
		$this->_errores[] = $error;
	}

	public function errores(){
		return $this->_errores;
	}

	public function passed(){
		return $this->_passed;
	}
}