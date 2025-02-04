<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = new Db ;

 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$txtcodigo =  $_GET['codigo'];



$sql = "SELECT  *
				  FROM adm.view_comb_vehi
				  where id_combus =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;


$resultado1 = $bd->ejecutar($sql);

$dataProv  = $bd->obtener_array( $resultado1);


$total_consumo = round(($dataProv['costo']) * ($dataProv['cantidad']),4) ;

$total_iva = round($total_consumo * (12/100),2);

$total     = round($total_consumo,4) + $total_iva;


echo json_encode( 
            array("a"=>trim($dataProv['id_combus']), 
                  "b"=> trim($dataProv['estado']) ,
                  "c"=> trim($dataProv['ubicacion_salida']) ,
                  "d"=> trim($dataProv['u_km_inicio']) ,
                  "e"=> trim($dataProv['tipo_comb']) ,
                  "f"=> ($dataProv['costo']) ,
                  "g"=> ($dataProv['cantidad']) ,
                  "h"=> $total_consumo ,
                  "i"=> ($dataProv['medida']) ,
                  "j"=> $total_iva ,
                  "k"=> $total  ,
                  "l"=>  $dataProv['cantidad_ca'] ,
                  "m"=>  $dataProv['idprov'] ,
                  "n"=>  $dataProv['operador'] ,
         )  
       );



 



?>