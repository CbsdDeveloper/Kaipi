<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db ;

$ruc     =  $_SESSION['ruc_registro'];

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio = $_GET['canio'];
$mes  = $_GET['cmes'];
 

    $cadena = ' ||  '. "' @ '";


 
  
	$sql = 'SELECT  V.fecharegistro AS "Fecha Registro",
							V.fechaemision AS "Fecha Emision",
		                    V.idprov '.$cadena.' as "Identificacion",
		                    V.razon as "Contribuyente",
							V.detalle ,
		                    V.comprobante as "Comprobante",
		                    V.secuencial '.$cadena.' as "Factura",
							V.tipocomprobante as "Tipo Comprobante" ,
							V.codsustento as "Cod Sustento" ,
							V.formadepago as "Forma de Pago" ,
		                    V.establecimiento  ||   V.puntoemision '.$cadena.' as "Serie",
		                    V.autorizacion '.$cadena.' as "Autorizacion",
							V.baseimponible as "Base Tarifa 0%",
		                    V.baseimpgrav as "Base Imponible",
		                    V.montoiva as "iva",
							V.valorretbienes as "Retencion IVA Bienes",
							V.valorretservicios as "Retencion IVA Servicios",
							V.valretserv100 as "Retencion IVA 100" ,
							V.serie1 AS "Serie Retencion", 
							V.autretencion1  '.$cadena.' AS "Autorizacion Retencion", 
							a.codretair as "Codigo", 
							a.baseimpair  as "Base Retencion",
							a.porcentajeair  as "Porcentaje Retencion",
							a.valretair   as "Monto Retencion"
		                    FROM view_anexos_compras V
							join view_anexos_compras x on  
								   x.id_compras = V.id_compras and V.mes= '.$bd->sqlvalue_inyeccion($mes,true).' AND 
                                   V.registro= '.$bd->sqlvalue_inyeccion( $_SESSION['ruc_registro'],true).' AND 
                                   V.anio = '.$bd->sqlvalue_inyeccion($anio,true). '
							left join view_anexos_fuente a on a.id_compras = V.id_compras and a.baseimpair > 0';
		                         

  

$resultado	= $bd->ejecutar($sql);
$tipo 		= $bd->retorna_tipo();

 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header('Content-disposition: attachment; filename='.rand().'.xls');
header("Pragma: no-cache");
header("Expires: 0");

echo utf8_decode($obj->grid->KP_GRID_EXCEL($resultado,$tipo)) ;
 
?>  
