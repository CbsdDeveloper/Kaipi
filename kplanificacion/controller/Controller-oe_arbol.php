<?php   

session_start();

require '../../kconfig/Db.class.php';

require '../../kconfig/Obj.conf.php';

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$sql_nivel1 = "SELECT count(nivel) as nn , nivel
 	                 FROM planificacion.pyestrategia
                     WHERE estado = 'S'
                group by nivel";

$stmt_nivel1 = $bd->ejecutar($sql_nivel1);



while ($x=$bd->obtener_fila($stmt_nivel1)){
    
    $nivel 						= trim($x['nivel']);
    $nn 						= $x['nn'];
    
    if (  $nivel  == '1'){
        $nivel1 =  $nn 	;
        
    }
    if (  $nivel  == '2'){
        $nivel2 =  $nn 	;
    }
    if (  $nivel  == '3'){
        $nivel3 =  $nn 	;
    }
}


?>
<div class="col-md-4">
 		<div class="alert alert-success">
  <strong style="font-size: 22px">NIVEL 1</strong> <br><a href="#" >
  <span onClick="goToURLDato(1)" title="Dar un click para visualizar informacion" style="font-size: 20px"> PLAN NACIONAL DE DESARROLLO </span> </a>
  <span class="badge"><?php echo   $nivel1;  ?></span>
</div>
</div> 

              
  <div class="col-md-4">
 		<div class="alert alert-info">
  <strong  style="font-size: 22px">NIVEL 2</strong> <br><a href="#" >
  <span onClick="goToURLDato(2)" title="Dar un click para visualizar informacion" style="font-size: 20px"> POLITICA/PDOT ESTRATEGIA NACIONAL/LOCAL</span> </a>
  <span class="badge"><?php echo   $nivel2;  ?></span>
</div>
</div>      

  <div class="col-md-4">
 		<div class="alert alert-warning">
  <strong  style="font-size: 22px">NIVEL 3</strong><br><a href="#" >
  <span onClick="goToURLDato(3)" title="Dar un click para visualizar informacion" style="font-size: 20px">  PLAN ESTRATEGICO INSTITUCIONAL PEI</span> </a>
  <span class="badge"><?php echo   $nivel3;  ?></span>
</div>
</div>      

		    
