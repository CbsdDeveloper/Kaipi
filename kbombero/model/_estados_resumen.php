<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

 
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$anio = date('Y');

$sql         = "SELECT   count(*) as vence  
                FROM bomberos.view_emergencias
                where   anio = ".$bd->sqlvalue_inyeccion($anio ,true)." and estado in ('1','2','3','4','5')" ;
$resultado1  = $bd->ejecutar($sql);
$data_vence  = $bd->obtener_array( $resultado1);

$sql         = "SELECT   count(*) as vence  
                FROM bomberos.view_emergencias
                where   anio = ".$bd->sqlvalue_inyeccion($anio ,true)." and estado in ('4','5')" ;
$resultado  = $bd->ejecutar($sql);
$data_util   = $bd->obtener_array( $resultado);
 

$sql         = "SELECT   sum(personas_heridas::numeric)  as vence  
                FROM bomberos.view_emergencias
                where anio =".$bd->sqlvalue_inyeccion($anio ,true) ;
                
$resultado   = $bd->ejecutar($sql);
$data_malo   = $bd->obtener_array( $resultado);

 
 


echo json_encode( array("a"=>$data_vence['vence'] ,
                        "b"=>$data_util['vence'] ,
                        "c"=>$data_malo['vence'] 
                )
    );
 


 

?>