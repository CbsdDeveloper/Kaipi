<?php
session_start( );  
require '../../kconfig/Db.class.php';
require '../../kconfig/Db.conf.php';
require '../../kconfig/Obj.conf.php';
$obj     = 	new objects;
$bd	   =	Db::getInstance();
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

  
     if (isset($_GET['anio']))	
     {
          $anio =  $_GET['anio']; 
          $mes  =  $_GET['mes']; 
            
          $cadena = "'  '"; 
         
		  $fecha = " to_char(A.FECHAEMISION,'DD/MM/RRRR') as FECHAEMISION ";
		 
		  $sql = "SELECT 
						  ".$cadena." || A.IDCLIENTE as IDENTIFICACION , A.BENEFICIARIO, 
							 A.TIPOCOMPROBANTE, 
						   A.SECUENCIAL, A.CODESTAB, A.NUMEROCOMPROBANTES, 
						   ".$fecha.", 
						   A.BASENOGRAIVA, A.BASEIMPONIBLE, 
						   A.BASEIMPGRAV, A.MONTOIVA, A.VALORRETBIENES, 
						   A.VALORRETSERVICIOS,  A.TIPOEMISION, 
						   A.FORMAPAGO, A.TIPOCOMPE, A.MONTOC
						FROM ANE_VENTAS A
						where A.MES = '".$mes."' and A.ANIO = ".$anio;
                
       }
   
    $resultado  = $bd->ejecutar($sql);
    $tipo 		= $bd->retorna_tipo();
    $tbHtml = $obj->grid->KP_GRID_EXCEL($resultado,$tipo); 
    header ('Content-type: text/html; charset=utf-8');
    header("Content-type: application/octet-stream");
 	header("Content-Disposition: attachment; filename=ResumenVentas.xls");
	header("Pragma: no-cache");
	header("Expires: 0"); 
 	echo $tbHtml; 
?>