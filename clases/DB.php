<?php
//usamos el patrón Singleton, para conectarnos sólo una vez aunque haya muchas consultas
class DB{
	private static $_instance = null; //para la instancia de la conexión a la db
	private $_pdo, //objeto para la conexión a la base de datos
			$_query, //la consulta realizada
			$_error = false,
			$_resultados,
			$_contador = 0;

	//función para conexión a la base de datos
	private function __construct(){
		//vamos a usar la clase PDO, que ya viene en PHP7
		try{
			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';
				dbname=' . Config::get('mysql/db'),
				Config::get('mysql/username'),
				Config::get('mysql/password')
				);
			//echo 'Connected';
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public static function getInstance(){
		//usamos self porque es una función static
		//si no hay una conexión a la base de datos, creamos una; si ya la hay, no.
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	//Función para realizar la consulta. El primer argumento es la consulta, el segundo es un array con los parámetros que queramos añadir.
	public function query($sql, $params = array()){
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			$x = 1;

			if(count($params)){
				foreach($params as $param){ 
					$this->_query->bindValue($x, $param); 
					$x++;
				}
			}

			if($this->_query->execute()){
				$this->_resultados = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_contador = $this->_query->rowCount();
			}else{
				echo '<br> Fail <br>'; //print_r($this->_pdo->errorInfo());
				$this->_error = true;
			}
		}
		//print_r($this->_query);
		return $this;
	}


 public function findAll($table){ 
 	return $this->action('SELECT *',$table);
 	 } 
 public function findById($id,$table){ 
 	return $this->action('SELECT *',$table,array('id','=',$id));
 	 }



	/**FUNCIONES AUXILIARES**/
	//no son realmente necesarias, pero agilizan la realización de consultas

	//función para realizar la consulta, $action es el tipo(borrar, obtener, etc...)
	private function action($action, $table, $where = array()){
		//$where es lo que viene tras WHERE en la consulta
		if(count($where) === 3){
			$operators = array('=', '>', '<', '>=', '<=');

			$field    = $where[0];
			$operator = $where[1];
			$value    = $where[2];

			if(in_array($operator, $operators)){ //si $operator está en $operators
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				//ahora usamos la función query()
				if(!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}

	//función para obtener
	//NO ME GUSTA LO DE SELECCIONAR TODO. VER CÓMO CAMBIARLO
	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	//función para borrar
	public function delete($table, $where){
		return $this->action('DELETE', $table, $where);
	}

	//función para insertar
	public function insert($table, $fields = array()){
		
		if(count($fields)){
			$keys = array_keys($fields); 
			
			$sql = "INSERT INTO {$table} (".implode(', ', $keys).") VALUES (".implode(',', array_fill(0, count($keys), '?')).")";

			if(!$this->query($sql, $fields)->error()){
				return true;
			}
		}
		return false;
	}

	//función para actualizar
	public function update($table, $id, $fields){
		$set = '';
		$x = 1;

		foreach($fields as $name=>$value){
			$set .= "{$name} = ?"; 
			if($x<count($fields)){
				$set .= ',';
			}
			$x++;
		}
		//$set = implode(' = ?, ', array_keys($fields)) . ' = ?';
		$sql = "UPDATE {$table} SET {$set} WHERE idUsuario = {$id}";
		
		
		
		if(!$this->query($sql, $fields)->error()){
			return true;
		}
		return false;


	}

	/**FIN DE FUNCIONES AUXILIARES**/


	public function error(){
		return $this->_error;
	}

	public function count(){
		return $this->_contador;
	}

	public function resultados(){
		return $this->_resultados;
	}

	public function first(){
		return $this->resultados()[0];
	}
}