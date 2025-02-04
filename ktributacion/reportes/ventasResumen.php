<?php
session_start( );  
require '../../kconfig/Db.class.php';
require '../../kconfig/Db.conf.php';
require '../../kconfig/Obj.conf.php';


$obj     = 	new objects;
$bd     = 	new Db;
 
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

     if (isset($_GET['anio']))	
     {
          $anio =  $_GET['anio']; 
          $mes  =  $_GET['mes']; 
            
		  $ruc_registro =  $_SESSION['ruc_registro'];
          
		  $cadena = '"';
		  $sql ="SELECT  '". $cadena ."   ' || idcliente  || '  ' as identificacion,
                          razon as cliente,
                          sum(numerocomprobantes) || ' ' as  transaccion,
                          sum(montoiva) as iva,
                          sum(baseimpgrav) as baseimponible,
                          sum(baseimponible) as tarifa0,
                          sum(valorretbienes) + sum(valorretservicios) as retencion_iva,
						  sum(valorretrenta) as retencion_fuente
                    FROM  view_anexos_ventas
                    where  
                           anio= ".$bd->sqlvalue_inyeccion($anio , true)." and 
						   mes= ".$bd->sqlvalue_inyeccion($mes , true)." and
                           registro = ".$bd->sqlvalue_inyeccion($ruc_registro , true)."
                      group by  idcliente,    razon
                     order by razon ";
 
									
       }
       
    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    $tbHtml = utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)); 

    header ('Content-type: text/html; charset=utf-8');
    header("Content-type: application/octet-stream");
 	header("Content-Disposition: attachment; filename=ResumenVentasMes.xls");
	header("Pragma: no-cache");
	header("Expires: 0"); 
 	echo $tbHtml; 
?>