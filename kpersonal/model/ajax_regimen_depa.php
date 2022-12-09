<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    
 
 
    $sql1 = 'SELECT regimen as codigo , regimen as nombre
		   FROM nom_regimen
						where activo = '.$bd->sqlvalue_inyeccion('S',true).' order by 2' ;
    

 
    

$stmt1 = $bd->ejecutar($sql1);


echo '<option value="'.'-'.'">'.'[ 0. Seleccione regimen laboral ]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
     
 ?>