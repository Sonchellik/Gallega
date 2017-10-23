<?php
require_once 'core/init.php';

 include 'includes/cabecera.php';
 if(Session::exists('usuario')){ 
     $usuario = new Usuario(); 
 
    echo '<div class="text-right">
        <a href="perfil.php?id=';
    echo $usuario->data()->idUsuario;
    echo '"> <div class="btn">Mi Perfil</div></a>
     </div>';
  
 }else{

?>
    <div class="text-right">
        <a href="login.php"><div class="btn">Acceso Profesionales</div></a>
    </div>
<?php } ?>

<div class="text-center">
<h3>Distribución de productos para tiendas de mascotas</h3>
<h4>Venta exclusiva a profesionales del sector</h4>
</div>
<br>
   
    <div class="row">
    	<div class="col-sm-2 col-sm-offset-1">
    		<a class="enlace" href="assets/catalogos/Catalogo2g-r2017.pdf" target="_new" data-toggle="tooltip" title="2g-r">
    		<img  src="assets/img/2g-r300.png" class="img-responsive" alt="2g-r">
    		</a>
    	</div>
    	<div class="col-sm-2 col-sm-offset-2">
    		<a class="enlace" href="http://cede.be/pt/os-nossos-produtos" target="_new" data-toggle="tooltip" title="CéDé">
    		<img src="assets/img/cede300.jpeg" class="img-responsive" alt="CeDe">
    		</a>
    	</div>
    	<div class="col-sm-2 col-sm-offset-2">
    		<a class="enlace" href="assets/catalogos/catalogoCunipic.pdf" target="_new" data-toggle="tooltip" title="Cunipic"><img class="img-responsive" src="assets/img/cunipic300.png" alt="Cunipic">
    		</a>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-sm-3 col-sm-offset-1">
    		<a class="enlace" href="assets/catalogos/catalogoSisalfibre-2017.pdf" target="_new"
    		data-toggle="tooltip" title="Sisal Fibre"><img class="img-responsive" src="assets/img/sisalfibre300.png" alt="Sisal Fibre">
    		</a>
    	</div>
    	<div class="col-sm-3 col-sm-offset-1">
    		<a class="enlace" href="https://www.magglance.com/Magazine/5ccca339062112ae48a720bad1456bc5/white" target="_new"
    		data-toggle="tooltip" title="Nekton"><img class="img-responsive" src="assets/img/Nekton300.png" alt="Nekton">
    		</a>
    	</div>
    	<div class="col-sm-3 col-sm-offset-1">
    		<a class="enlace" href="http://www.valpet.it/it/" target="_new" data-toggle="tooltip" title="Valpet"><img class="img-responsive" src="assets/img/valpet300.png" alt="Valpet">
    		</a>
    	</div>
    </div>

     <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
            <a class="enlace" href="assets/catalogos/Jaulas.pdf" target="_new"
            data-toggle="tooltip" title="Jaulas"><img class="img-responsive" src="assets/img/Jaulas.jpg" alt="Jaulas">
            </a>
        </div>
    </div>
    
<br><br>

<?php
include 'includes/pie.php';