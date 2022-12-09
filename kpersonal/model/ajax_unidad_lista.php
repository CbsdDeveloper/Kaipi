<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	       =  new Db ;

    $ruc       =  trim($_SESSION['ruc_registro']);

   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
     
    $sql1 = 'SELECT id_departamento as codigo , unidad AS  nombre
		       FROM view_nomina_rol
               where registro = '.$bd->sqlvalue_inyeccion(  $ruc, true).'
		   group by id_departamento,  unidad
           order by 2'  ;
    
 

$stmt1 = $bd->ejecutar($sql1);


echo '<option value="'.'-'.'">'.' [  0. Seleccione unidad administrativa ] '.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
     
 ?>