<?php
require_once 'core/init.php';

$usuario = new Usuario();

if(!$usuario->isLoggedIn()){
	Redirect::to('index.php');
}

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'contraseña_actual' => array(
				'required' => true,
				'min' => 8
				),
			'nueva_contraseña' => array(
				'required' => true,
				'min' => 8
				),
			'nueva_contraseña_again' => array(
				'required' => true,
				'min' => 8,
				'matches' => 'nueva_contraseña'
				)
			));
		if($validation->passed()){
			if(!password_verify(Input::get('contraseña_actual'), $usuario->data()->contraseña)){
				echo 'Contraseña errónea';
			}else{
				$usuario->actualizar(array(
					'contraseña' => Hash::make(Input::get('nueva_contraseña'))));
				//Session::flash('home', 'Contraseña actualizada');
				Redirect::to("perfil.php?id=" . $usuario->data()->idUsuario);
			}
		}else{
			foreach($validation->errores() as $error){
				echo $error, '<br>';
			}
		}
	}
}
include 'includes/cabecera.php';
?>

<form action="" method="post">
	<div class="form-group">
		<label for="contraseña_actual">Contraseña actual</label>
		<input type="password" class="form-control" name="contraseña_actual" id="contraseña_actual" placeholder="Introduzca su contraseña actual">
	</div>
	<div class="form-group">
		<label for="nueva_contraseña">Nueva contraseña</label>
		<input type="password" class="form-control" name="nueva_contraseña" id="nueva_contraseña" placeholder="Introduzca la nueva contraseña">
	</div>
	<div class="form-group">
		<label for="nueva_contraseña_again">Repita nueva contraseña</label>
		<input type="password" class="form-control" name="nueva_contraseña_again" id="nueva_contraseña_again" placeholder="Introduzca la nueva contraseña de nuevo">
	</div>
		<input type="submit" value="Cambiar">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	
</form>
<?php
include 'includes/pie.php';