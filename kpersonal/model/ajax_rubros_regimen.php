<?php   

    session_start(); 
 
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
 
    
    $bd	   =	    new Db ;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $accion             = $_GET['tipo'];
    
 
 
    $sql1 = "SELECT id_config as codigo, nombre
        FROM  nom_config
        where tipo =".$bd->sqlvalue_inyeccion(trim( $accion   ),true)." and estado = 'S'
        order by 2" ;
    
 

$stmt1 = $bd->ejecutar($sql1);


echo '<option value="'.'-'.'">'.'[ 0. Seleccione rubro para generar ]'.'</option>';

while ($fila=$bd->obtener_fila($stmt1)){
    
    echo '<option value="'.$fila['codigo'].'">'.trim($fila['nombre']).'</option>';
    
}
     
 ?>