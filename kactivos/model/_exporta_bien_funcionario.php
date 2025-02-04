<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$id =  trim($_GET['id']);


$qquery = array( 
    array( campo => 'id_bien',valor => '-',filtro =>'N', visor => 'S'),
    array( campo => 'clase',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'unidad',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'vida_util',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'tiempo_anio',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'fecha_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'tiene_acta',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'idprov',valor => $id  ,filtro => 'S', visor => 'S'),
    array( campo => 'costo_adquisicion',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'idsede',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'tipo_bien',      valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
    array( campo => 'razon',         valor => '-',filtro => 'N' , visor => 'S'),
    array( campo => 'detalle',            valor => '-',filtro => 'N', visor => 'S') 
);


$stmt1 = $bd->JqueryCursorVisor('activo.view_bienes',$qquery);

 
 
            
           $tipo = $bd->retorna_tipo();
              
           $tbHtml = $obj->grid->KP_GRID_EXCEL($stmt1,$tipo);
            
             
           $fecha = "bienes_".date('Y-m-d');
           
           header("Content-type: application/vnd.ms-excel");
           header("Content-Disposition: attachment; filename=".$fecha.".xls");
           header("Pragma: no-cache");
           header("Expires: 0");
           
           echo utf8_decode($tbHtml);
            
 

?>