<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/



$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$sql =  'SELECT tipo, tipo_bien,sede, unidad,idprov as identificacion, razon as custodio,id_bien,fecha, forma_ingreso,  descripcion,  
origen_ingreso,   clase_documento, tipo_comprobante, fecha_comprobante, 
codigo_actual, estado, costo_adquisicion, depreciacion, serie, 
  cuenta, valor_contable, valor_residual,  valor_depreciacion, 
anio_depre, vida_util, color, dimension, uso, fecha_adquisicion, clase, material,   
tiene_acta, tipo_ubicacion, clase_esigef, marca, detalle,   anio, 
detalle_ubica,  anio_adquisicion, mes_adquisicion, tiempo_dia, tiempo_anio, 
  proveedor,factura,  garantia, tiempo_garantia,
sesion, creacion, sesionm, modificacion
FROM activo.view_bienes
order by id_bien';


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