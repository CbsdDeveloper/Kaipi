<?php
session_start( );   
ob_start();  
require 'inventarios-factura.php';   /*Incluimos el fichero de la clase Db*/
$g  	 = 	new componente;
$fecha 	 = $_GET["fecha"];
$cajero  = $_GET["cajero"];

$g->_get_caja();
$g->_cajero($cajero );
	 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 
 <style type="text/css">
 
	body {
		font-size: 11px;
		color:#000;
	    margin: 10mm 20mm 20mm 20mm;
	}

	.tableCabecera{
 	margin:3px 0 3px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
	width: 100%  
  	}
	 
	.tableForm{
 /*	margin:3px 0 3px 0; */
	border-collapse:collapse;
	border: .40mm solid thin #909090;
	width: 100%  
  	}
	 
 .tableFirmas{
 	margin:10px 0 10px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
  	}
	 
 .titulo{
	padding-left: 10px;
	padding-bottom: 2px;
	font-weight: bold;
	color: #5B5B5B
  	}
	 
 .titulo1{
	padding-left: 10px;
	padding-bottom: 2px;
 	color: #5B5B5B
  	}
	 
  .MensajeCab{
	padding-left: 10px;
	padding-bottom: 5px;
	font-weight:100;
	font-size: 11px;
	color:#636363
  	}
 
  .Mensaje{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
    
	 .grillaTexto{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
   	}	 
	 
	 .Mensaje1{
	font-size: 12px;
	padding-left: 5px;
	padding-right: 15px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
	 
  .linea{
		border: .40mm solid thin #909090;
	   padding: 20px;
  	}	

	 .linea1{
		border: .40mm solid thin #909090;
	   padding: 5px;
  	}	
	 
	 table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}
 </style>
    
</head>

<body>
	
	<h3><?php echo $g->_getEmpresa('razon'); ?></h3>
	<h4>PLATAFORMA DE GESTIÓN DE EMPRESARIAL<br>
	    CIERRE DE CAJAS POR USUARIO<br>
		RESUMEN DETALLE DE PAGO<br>
		CAJA DEL DIA <?php echo $fecha ; ?><br>
		USUARIO <?php echo $g->_get_cajero('completo') ; ?>
	</h4>
 
	 <table  width="100%" >
      <tbody>
        <tr>
          <td    align="center" valign="middle">Fecha</td>
          <td     align="center" valign="middle">Forma Pago</td>
          <td  align="center" valign="middle">Tipo Pago</td>
          <td    align="center" valign="middle">Institucion</td>
          <td    align="center" valign="middle">Nro.Cuenta</td>
          <td    align="right" valign="middle">Pago</td>
		</tr>
 		  <?php   $g->resumenPago($fecha,trim($cajero));  ?>
       </tbody>
    </table> 
 <h4> RESUMEN DETALLE DE PRODUCTOS </h4>
	 <table  width="100%" >
      <tbody>
        <tr>
          <td    align="center" valign="middle">Fecha</td>
          <td     align="center" valign="middle">Producto</td>
          <td  align="center" valign="middle">Cantidad</td>
          <td    align="center" valign="middle">Precio</td>
          <td    align="center" valign="middle">Base Imponible</td>
		  <td    align="center" valign="middle">Iva</td>
		 <td    align="center" valign="middle">Tarifa Cero</td>
          <td    align="center" valign="middle">Total</td>
			</tr>
 		  <?php   $g->resumenProducto($fecha,$cajero);  ?>
       </tbody>
    </table> 
	
 <h4> TOTAL RESUMEN VENTAS </h4>
	 <table  width="100%" >
      <tbody>
        <tr>
          <td    align="center" valign="middle">Fecha</td>
          <td     align="center" valign="middle">Nro.Facturas</td>
           <td    align="center" valign="middle">Base Imponible</td>
		  <td    align="center" valign="middle">Iva</td>
		 <td    align="center" valign="middle">Tarifa Cero</td>
          <td    align="center" valign="middle">Total</td>
			</tr>
 		  <?php   $g->resumenVenta($fecha,$cajero);  ?>
       </tbody>
    </table> 
   <h4 align="justify"><?php echo $g->informe_cierre($fecha,$cajero); ?></h4>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>	
	
<table class="tableFirmas" width="100%" >
  <tr>
    <td class="linea" >&nbsp; </td>
    <td class="linea" >&nbsp; </td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">Firma Autorizada</td>
    <td width="50%" class="linea1" align="center" valign="middle">Recibi Conforme</td>
  </tr>
	
</table>

</body>
</html>