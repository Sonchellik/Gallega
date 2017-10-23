<?php
require_once 'core/init.php';

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array('required' => true),
			'contraseña' => array('required' => true)
			));
		if($validation->passed()){ 
			$usuario = new Usuario();
			$recuerda = Input::get('recuerda') === 'on' ? true : false;
			$login = $usuario->login(Input::get('email'), Input::get('contraseña'), $recuerda);

			 if($login){ 
				Redirect::to("perfil.php?id=" . $usuario->data()->idUsuario);
				}
			
		}
		else{
			foreach ($validation->errores() as $error) {
				echo '<div class="alert alert-info"><strong>ATENCIÓN: </strong>'. $error . '</div>', '<br>';
			}
		}
	}
}
include 'includes/cabecera.php';
?>

<form action = "" method = "post">
 <div class = "form-group">
 <label for="email">Correo electrónico</label>
 <input type="email" class="form-control" name="email" id="email" placeholder="Introduzca su correo electrónico" autocomplete="off">
 </div>
 <div class = "form-group">
 <label for="contraseña">Contraseña</label>
 <input type="password" class="form-control" name='contraseña' id="contraseña" placeholder="Introduzca su contraseña" autocomplete="off">
 </div>
 <div class="form-group">
 	<label for="recuerda">
 	<input type="checkbox"  name="recuerda" id="recuerda">Recuérdame
 	</label>
 </div>
 <input type = "hidden" name = "token" value="<?php echo Token::generate();?>">
 <input type = "submit" value = "Acceder">
 </form>
 <br><br>
<div class='wrapper'>


<p>Si desea que le incluyamos como ususario, solicítelo <a href="solicitudRegistro.php">aquí</a></p>
<br><br><br>
 <?php
include 'includes/pie.php';