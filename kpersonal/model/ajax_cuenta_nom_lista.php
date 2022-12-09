<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
    $anio         =  $_SESSION['anio'];
    
    $cuenta       = trim($_GET['cuenta']);
    
    $grupo        = substr($cuenta, 0,2);
  
    
    $sql2 = "SELECT cuenta as codigo , cuenta ||' ' || detalle as nombre
		   FROM co_plan_ctas
		  where debito = ".$bd->sqlvalue_inyeccion(trim($cuenta),true)." and  univel= 'S' and
                anio = ".$bd->sqlvalue_inyeccion($anio,true)  ;
    
 
    $sql1 = "SELECT cuenta as codigo , cuenta ||' ' || detalle as nombre
		   FROM co_plan_ctas
		  where credito = ".$bd->sqlvalue_inyeccion(trim($grupo),true).' and
                anio = '.$bd->sqlvalue_inyeccion($anio,true)."
                and tipo_cuenta in ('D','P') and univel= 'S' union ".$sql2." 
            order by 1" ;
 
  
$stmt1 = $bd->ejecutar($sql1);


echo '<option value="'.'-'.'">'.'[ 0. Seleccione Cuenta ]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.trim($fila['codigo']).'">'.trim($fila['nombre']).'</option>';
    
}
     
 ?>