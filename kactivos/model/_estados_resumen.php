<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$sql         = "SELECT   count(*) as vence  FROM activo.view_bienes_vence where dias_recepcion between -31 and 31" ;
$resultado1  = $bd->ejecutar($sql);
$data_vence  = $bd->obtener_array( $resultado1);

$sql         = "SELECT   count(*) as vence  FROM activo.view_bienes_novedad" ;
$resultado  = $bd->ejecutar($sql);
$data_util   = $bd->obtener_array( $resultado);
 

$sql         = "SELECT   count(*) as vence  FROM activo.view_bienes where estado = 'Malo' and uso <> 'Baja' " ;
$resultado   = $bd->ejecutar($sql);
$data_malo   = $bd->obtener_array( $resultado);

$sql         = "SELECT   count(*) as vence  FROM activo.view_bienes where baja_c = 'P' and uso = 'Baja' " ;
$resultado   = $bd->ejecutar($sql);
$data_pordar   = $bd->obtener_array( $resultado);

$pordar = '<div class="alert alert-info"><strong>'.$data_pordar['vence'].'</strong> BIENES POR DAR DE BAJA POR REPOSICION.</div>';
 

$sql         = "SELECT   count(*) as vence  FROM activo.view_bienes where  uso = 'Libre' " ;
$resultado   = $bd->ejecutar($sql);
$data_libre   = $bd->obtener_array( $resultado);

$libre = '<div class="alert alert-warning"><strong>'.$data_libre['vence'].'</strong> BIENES POR GENERAR ACTAS DE ENTREGA.</div>';
 

echo json_encode( array("a"=>$data_vence['vence'] ,
                        "b"=>$data_util['vence'] ,
                        "c"=>$data_malo['vence'] ,
                        "d"=>$pordar ,
                        "e"=>$libre 
                )
    );
 


 

?>