<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   

 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
 
 
    $sql1 = "SELECT idprov as codigo ,  razon ||'/'|| cargo  as nombre
		      FROM view_nomina_user
			  where responsable = ".$bd->sqlvalue_inyeccion('S',true).'  and 
                    idprov is not null order by 2' ;
    
 

$stmt1 = $bd->ejecutar($sql1);


echo '<option value="'.'-'.'">'.'[ 0. Seleccione Responsable Actividades ]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
     
 ?>