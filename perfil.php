<?php
require_once 'core/init.php';
include 'includes/cabecera.php';
 if(!$id = $_GET['id']){
	Redirect::to('index.php'); 
}else{
     $id = $_GET['id'];
 	$usuario = new Usuario();
 }

if($usuario->data()->idUsuario === $id){
    if($usuario->isLoggedIn()){
    ?>
    <div class="wrapper">
        <p>Hola, <?php echo escape($usuario->data()->nombre);?> </p>
        <ul class="list-group">
            <li class="list-group-item lista-perfil"><a href="assets/catalogos/catalogoPrecios.pdf">Catálogo</a></li>
            <li class="list-group-item lista-perfil"><a href="actualizar.php">Actualizar</a></li>
            <li class="list-group-item lista-perfil"><a href="cambiarContraseña.php">Cambiar contraseña</a></li>
            <li class="list-group-item lista-perfil"><a href="logout.php">Cerrar sesión</a></li>
        </ul>

    </div>
    <?php
        }else{
            echo '<p><a href="register.php">Regístrese</a> o <a href="login.php">inicie sesión</a>.</p>';
        }
}else{
    echo 'No tiene autorización para ver esta página';
}

include 'includes/pie.php';