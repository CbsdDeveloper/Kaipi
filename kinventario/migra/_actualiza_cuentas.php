<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$response = 'Datos procesados';

 


//view_facturacion_adicional



$sql = "SELECT * FROM migra.existencia2019";



$stmt = $bd->ejecutar($sql);

$i = 1 ;

while ($fila=$bd->obtener_fila($stmt)){
    
    $id = trim($fila['codigo']);
    $cuenta = trim($fila['cuenta']);
    
    
    $sqlPillaro = "update public.web_producto 
                     set cuenta_inv =".$bd->sqlvalue_inyeccion( $cuenta ,true) ." 
                   where idproducto = ".$bd->sqlvalue_inyeccion( $fila["codigo"] ,true) ;
    
    
    
    $bd->ejecutar($sqlPillaro);
    
    $i++;
}

$response = 'Registros '.$i. ' Movimiento '.$id;




echo $response;

  



?>
 
  