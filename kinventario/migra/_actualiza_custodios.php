<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$response = 'Datos procesados';

 


//view_facturacion_adicional



$sql = "SELECT * FROM activo.ac_bienes_custodio
ORDER BY id_bien_custodio ASC";



$stmt = $bd->ejecutar($sql);

$i = 1 ;

while ($fila=$bd->obtener_fila($stmt)){
    
    $id = trim($fila['id_bien_custodio']);
    $idprov = trim($fila['idprov']);
    
    $x = $bd->query_array('view_nomina_rol',   // TABLA
        '*',                        // CAMPOS
        'idprov='.$bd->sqlvalue_inyeccion($idprov,true) // CONDICION
        );
 
    
    $sqlPillaro = "update activo.ac_bienes_custodio
                     set id_departamento =".$bd->sqlvalue_inyeccion( $x['id_departamento'] ,true) ." 
                   where id_bien_custodio = ".$bd->sqlvalue_inyeccion( $id ,true) ;
    
    
    
    $bd->ejecutar($sqlPillaro);
    
    $i++;
}

$response = 'Registros '.$i. ' Movimiento '.$id;




echo $response;

  



?>
 
  