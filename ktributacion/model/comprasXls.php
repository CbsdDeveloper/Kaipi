<?php
 
    session_start( );  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    $obj     = 	new objects;
    
    $bd     = 	new Db;
    
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
 
  
     if (isset($_GET['anio']))	
     {
          $anio =  $_GET['anio']; 
          $mes  =  $_GET['mes']; 
            
  
		 
          $sql = "Select idprov as ruc, razon,correo, codsustento,tipocomprobante, fecharegistro, 
				   establecimiento, puntoemision, 
				   secuencial, 
				   fechaemision, 
				   '- '   ||  autorizacion as autorizacion, 
				   basenograiva, 
				   baseimponible, 
				   baseimpgrav, 
				   montoice, 
				   montoiva, 
				   valorretbienes, 
				   valorretservicios, 
				   valretserv100, 
				   porcentaje_iva, 
				   formadepago, fechaemiret1, serie1, secretencion1, autretencion1, serie, comprobante, detalle
                FROM view_anexos_compras 
                WHERE anio =  ".$anio.' and mes = '.$mes.' and registro = '. "'".trim($_SESSION['ruc_registro']). "'". ' 
                order by fecharegistro';
                
       }


    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
    header ('Content-type: text/html; charset=utf-8');
    header("Content-type: application/octet-stream");
    header('Content-type: application/vnd.ms-excel');
 	header("Content-Disposition: attachment; filename=ResumenCompras.xls");
	header("Pragma: no-cache");
	header("Expires: 0"); 
 	echo $tbHtml; 
?>