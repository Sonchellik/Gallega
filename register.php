<?php
require_once 'core/init.php';
include 'includes/cabecera.php';
if(Input :: exists()){
   if(Token::check(Input::get('token'))){
	$validate = new Validate();
	$validation = $validate -> check($_POST, array(
		'email' => array(
			'required' => true
			//VER QUÉ FALTA
			),
		'nombre' => array(
			'required' => true,
			'min' => 2,
			'max' => 50),
		'empresa' => array(
			'required' => false,
			'min' => 6),
		'contraseña' => array(
			'required' => true,
			'min' => 8),
		'contraseña_again' => array(
			'required' => true,
			'matches' => 'contraseña')
		));
   }




 if($validation->passed()){
 	$usuario = new Usuario();
 	
 	try{
 		$usuario->crear(array(
 			'email' => Input::get('email'),
 			'contraseña'=> Hash::make(Input::get('contraseña')),
 			'nombre' => Input::get('nombre'),
 			'empresa' => Input::get('empresa'),
 			'ingreso' => date('Y-m-d H:i:s'),
 			'grupo' => 2
 			));

/*********PARA CUANDO LOS USUARIOS SE PUEDAN REGISTRAR POR ELLOS MISMOS************/ 		
//  	$to = Input::get('email');
// 		$subject = "Confirmación de registro en Gallega de Ornitología";

// 		$message = "
// 		<html>
// 		<head>
// 		<title>Confirmación de registro en Gallega de Ornitología</title>
// 		</head>
// 		<body>
// 		<p>Para completar el registro en Gallega de Ornitología, pinche en el siguiente enlace.</p>
// 		<p>gallegadeornitologia.com/confirmacionRegistro.php</p>
// 		</body>
// 		</html>
// 		";

// 		// Poner siempre content-type al enviar HTML
// 		$headers = "MIME-Version: 1.0" . "\r\n";
// 		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// 		// Más headers
// 		$headers .= 'From: <gallegadeornitologia@gmail.com>' . "\r\n";
// 		$headers .= 'Cc: sonia.b.rey@gmail.com' . "\r\n";

// 		mail($to,$subject,$message,$headers);



 	$to = Input::get('email');
		$subject = "Confirmación de registro en Gallega de Ornitología";

		$message = "
  			<html>
	 		<head>
	 		<title>Confirmación de registro en Gallega de Ornitología</title>
	 		</head>
			<body>
			<p>Ha sido incluido como usuario registrado en Gallega de Ornitología</p>
			<p>Su nombre de usuario es ";
		$message .= Input::get('email');
		$message .= "<br><p>Su contraseña es ";
		$message .= Input::get('contraseña');
		$message .= "<p>Para logarse, pinche en el siguiente enlace:</p>
			<p>gallegadeornitologia.com/login.php</p>
 			</body>
	 		</html>
	 		";

 		// Poner siempre content-type al enviar HTML
 		$headers = "MIME-Version: 1.0" . "\r\n";
 		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// Más headers
 		$headers .= 'From: <gallegadeornitologia@gmail.com>' . "\r\n";
 		$headers .= 'Cc: sonia.b.rey@gmail.com' . "\r\n";

 		mail($to,$subject,$message,$headers);




 		
 	}catch(Exception $e){
 		die($e->getMessage());
 	}
 }
 else{
 	foreach ($validation -> errores() as $error ) {
 		echo $error, '<br>';
 	}
 }
}


?>

<form action = "" method = "post">
 <div class = "form-group">
 <label for="email">Correo electrónico</label>
 <input type="email" class="form-control" name="email" id="email" placeholder="Introduce el correo electrónico">
 </div>
 <div class = "form-group">
 <label for="nombre">Nombre</label>
 <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Introduce el nombre">
 </div>
 <div class = "form-group">
 <label for="nombre">Empresa</label>
 <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Introduce el nombre de la empresa">
 </div>
 <div class = "form-group">
 <label for="contraseña">Contraseña</label>
 <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Introduce la contraseña">
 </div>
 <div class = "form-group">
 <label for="contraseña_again">Repita contraseña</label>
 <input type="password" class="form-control" name="contraseña_again" id="contraseña_again" placeholder="Vuelve a introducir la contraseña">
 </div>
 <input type = "hidden" name = "token" value="<?php echo Token::generate();?>">
 <input type = "submit" value = "Registro">
 </form>