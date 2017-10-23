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
			'min' => 6)
		));
   }

if($validation->passed()){

	$to = "sonia.b.rey@gmail.com";
	$subject = "Solicitud de registro en Gallega de Ornitología";

	$message = "
		<html>
		<head>
		<title>Solicitud de registro en Gallega de Ornitología</title>
		</head>
		<body>
		<p>La siguiente persona ha solicitado el registro como ususario en Gallega de Ornitología</p>";
	$message .= "<p>Nombre: ";
	$message .= Input::get('nombre');
	$message .= "</p>";
	$message -= "<p>Correo electrónico: ";
	$message .= Input::get('email');
	$message .= "</p>";
	$message .= "<p>Empresa: ";
	$message .=	Input::get('empresa');
	$message .= "</p></body>
		</html>
		";

		// Poner siempre content-type al enviar HTML
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// Más headers
		$headers .= 'From: <gallegadeornitologia@gmail.com>' . "\r\n";
		//$headers .= 'Cc: sonia.b.rey@gmail.com' . "\r\n";

		mail($to,$subject,$message,$headers);
		Redirect::to("index.php");
 }
}
?>
<h4>Rellene este formulario si desea tener acceso como usuario registrado.</h4>
<form action = "" method = "post">
 <div class = "form-group">
 <label for="email">Correo electrónico</label>
 <input type="email" class="form-control" name="email" id="email" placeholder="Introduzca su correo electrónico">
 </div>
 <div class = "form-group">
 <label for="nombre">Nombre</label>
 <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Introduzca su nombre">
 </div>
 <div class = "form-group">
 <label for="empresa">Empresa</label>
 <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Introduzca el nombre de su empresa">
 </div>
 
 <input type = "hidden" name = "token" value="<?php echo Token::generate();?>">
 <input type = "submit" value = "Solicitud Registro">
 </form>
<?php
include 'includes/pie.php';