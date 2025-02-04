<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$sql =  trim($_SESSION['sql_activo']);


if ( $sql) {
 
            
           $tipo = $bd->retorna_tipo();
    
           $stmt1 = $bd->ejecutar($sql);
            
           $tbHtml = $obj->grid->KP_GRID_EXCEL($stmt1,$tipo);
            
             
           $fecha = "bienes_".date('Y-m-d');
           
           header("Content-type: application/vnd.ms-excel");
           header("Content-Disposition: attachment; filename=".$fecha.".xls");
           header("Pragma: no-cache");
           header("Expires: 0");
           
           echo utf8_decode($tbHtml);
            
}

?>