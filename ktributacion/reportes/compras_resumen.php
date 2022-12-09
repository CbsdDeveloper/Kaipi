<?php session_start( );   

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	 
    $obj   = 	new objects;
	$bd     = 	new Db;
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $periodo =  $_GET['periodo']; 
    $espacio = "'''' ||  ";
    
    $fecha1 = " to_char(V.FECHA_CONTABLE,'DD/MM/RRRR') ";//Formato de fecha.
    $fecha2 = " to_char(V.FEMISION,'DD/MM/RRRR') ";//Formato de fecha.
     
    $sql = '  SELECT  '.$fecha1.' as "Fecha Contable", 
             '.$espacio.' trim(V.IDENTIFICACION) as "Identificacion", 
             V.NOMBRE_CIU as "Contribuyente", 
             '.$fecha2.' as "Fecha_Emision" ,
             '.$espacio.' V.FACTURA as "Factura", 
             '.$espacio.' V.AUTORIZACION as "Autorizacion", 
             '.$espacio.' V.SERIE as "Serie", 
             V.BASE_GRABADA_TARIFA_CERO as "Base_Tarifa_Cero", 
             V.BASE_IMPONIBLE as "Base_Imponible", 
             V.IVA_VALOR AS "Monto_IVA",
             '.$espacio.' V.NRO_COMPROBANTE_RETENCION as "Comprobante_Retencion", 
            (RF_VALOR1 + RF_VALOR2) as "Retencion_Fuente",
             IVA_SERVICIOS_VALOR as "IVA_Servicios",
             IVA_BIENES_VALOR as "IVA_Bienes"
            FROM V_ANEXOS_TRANSACCIONAL V 
                WHERE TANIO|| TMES = '.$periodo.'
                order by V.FECHA_CONTABLE' ;
                    
    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
    
	header ('Content-type: text/html; charset=utf-8');
  // esto le indica al navegador que muestre el diálogo de descarga aún sin haber descargado todo el contenido
    header("Content-type: application/octet-stream");
 	//indicamos al navegador que se está devolviendo un archivo
	header("Content-Disposition: attachment; filename=resumen_compras.xls");
	//con esto evitamos que el navegador lo grabe en su caché
	header("Pragma: no-cache");
	header("Expires: 0");
 	//damos salida a la tabla
	echo $tbHtml; 															 
?>