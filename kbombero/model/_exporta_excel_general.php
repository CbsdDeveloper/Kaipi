<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$sql =  'SELECT id, fecha_emergencia, hora_aviso, parroquia, sector, informante, categoria_emergencia, tipo_de_emergencia, nombre_y_contacto_referencia, descripcion_emergencia, ubicacion_emergencia, medidas_adoptadas, personas_heridas, personas_fallecidas, daños_ambientales, daños_bienes, organismos_apoyo, personal_desplazado, arribo_emergencia, hora_desmovilizacion, hora_llegada_base
FROM ireport.lista_emergencias id';


if ( $sql) {
 
            
           $tipo = $bd->retorna_tipo();
    
           $stmt1 = $bd->ejecutar($sql);
            
           $tbHtml = $obj->grid->KP_GRID_EXCEL($stmt1,$tipo);
            
             
           $fecha = "emergencias_".date('Y-m-d');
           
           header("Content-type: application/vnd.ms-excel");
           header("Content-Disposition: attachment; filename=".$fecha.".xls");
           header("Pragma: no-cache");
           header("Expires: 0");
           
           echo utf8_decode($tbHtml);
            
}

?>