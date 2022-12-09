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
		font-size: 9px;
		color:#000;
	  /*  margin: 10mm 20mm 20mm 20mm;*/
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
   border: .40mm solid thin #909090;
}

	.cabecera_font {
 	 font-size: 10px;
	 font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
	 color:#4B4B4B;
	 border-collapse: collapse;
	 width: 100%;
   	}
 </style>
    
</head>

<body>
	
<table class="cabecera_font">
		  <tbody>
			<tr>
			  <td width="15%" valign="top"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="85%" style="padding-left: 10px" valign="top"><?php echo $g->Empresa(); ?><br><br><?php echo $g->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $g->_Cab( 'direccion' ); ?><br><?php echo $g->_Cab( 'telefono' ); ?><br>Modulo Facturacion<br>
				  CIERRE DE FACTURACION
				</td>
			</tr>
		  </tbody>
		</table>
	
	<h4> <br>
		CAJA DEL DIA <?php echo $fecha ; ?><br>
		USUARIO <?php echo $g->_get_cajero('completo') ; ?>
	</h4>
 
	<h4>  DETALLE DE FACTURAS </h4>
	   <table  width="100%" style="font-size: 10px">
      <tbody>
        <tr>
          <td align="center" valign="middle">Fecha</td>
          <td align="center" valign="middle">Nombres</td>
          <td align="center" valign="middle">Comprobante</td>
          <td align="center" valign="middle">Emision</td>
		  <td  align="center" valign="middle">Interes</td>
		  <td  align="center" valign="middle">Descuento</td>
		  <td  align="center" valign="middle">Recargo</td>
          <td align="center" valign="middle">Total</td>
			</tr>
 		  <?php   $g->resumenClientes($fecha,$cajero);  ?>
       </tbody>
    </table> 
		<h4> <br>
 
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
	
	
	
 <h4> RESUMEN DETALLE </h4>
	 <table  width="100%" style="font-size: 8px" >
      <tbody>
        <tr>
          <td    align="center" valign="middle">Fecha</td>
          <td     align="center" valign="middle">Producto</td>
          <td  align="center" valign="middle">Cantidad</td>
          <td    align="center" valign="middle">Precio</td>
          <td    align="center" valign="middle">Base Imponible</td>
		  <td    align="center" valign="middle">Iva</td>
		 <td    align="center" valign="middle">Tarifa Cero</td>
          <td    align="center" valign="middle">Total ($) </td>
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
	
	 <h4> TOTAL RESUMEN NOTAS DE CREDITO </h4>
	 <table  width="100%" style="font-size: 10px">
      <tbody>
        <tr>
          <td    align="center" valign="middle">Fecha</td>
			<td    align="center" valign="middle">Nombre</td>
          <td     align="center" valign="middle">Documento Modificado</td>
			 <td     align="center" valign="middle">Nota Credito</td>
           <td    align="center" valign="middle">Base Imponible</td>
		  <td    align="center" valign="middle">Iva</td>
		 <td    align="center" valign="middle">Tarifa Cero</td>
          <td    align="center" valign="middle">Total</td>
			</tr>
 		  <?php   $g->resumenVentaNotas($fecha,$cajero);  ?>
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
    <td class="linea1" align="center" valign="middle">Ing. Evelyn Mishell Bejarano Manzaba</td>
    <td class="linea1" align="center" valign="middle">Ing. Rosa Manobanda</td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">Tesorero(a)</td>
    <td width="50%" class="linea1" align="center" valign="middle">Analista de Tesorería</td>
  </tr>
	
</table>

</body>
</html>
<?php
	
 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "Cierre_Caja".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

 
		 
?> 