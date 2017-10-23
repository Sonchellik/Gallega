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
			'nombre' => array(
				'required' => true,
				'min' => 2,
				'max' => 50),
			'email' => array(
			 	'required' => true)
			/****¿POR QUÉ NARICES NO FUNCIONA REQUIRED FALSE????****/
			 // 'empresa' => array(
			 // 	'required' => false)
			));

		if($validation->passed()){
			try{
				$usuario->actualizar(array(
					'nombre' => Input::get('nombre'),
					'email' => Input::get('email'),
					'empresa' => Input::get('empresa')
					));
				//Session::flash('home', 'Your details have been updated');
				Redirect::to("perfil.php?id=" . $usuario->data()->idUsuario);
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach($validation->errores() as $error){
				echo '<div class="alert alert-info"><strong>ATENCIÓN: </strong>'. $error . '</div>', '<br>';
			}
		}
	}
}
include 'includes/cabecera.php';
?>

<form action="" method="post">
	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input type="text" class="form-control" name="nombre" value="<?php echo escape($usuario->data()->nombre);?>">
	 <div class = "form-group">
 		<label for="email">Correo electrónico</label>
 		<input type="email" class="form-control" name="email" id="email"  autocomplete="off" value="<?php echo escape($usuario->data()->email);?>">
 	 </div>
 	 <div class = "form-group">
		 <label for="empresa">Empresa</label>
		 <input type="text" class="form-control" name="empresa" id="empresa" value="<?php echo escape($usuario->data()->empresa);?>">
	 </div>
		<input type="submit" value="Actualizar">
		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	</div>
</form>

 <?php
include 'includes/pie.php';