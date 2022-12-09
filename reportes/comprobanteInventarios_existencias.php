<?php 
session_start( );   
ob_start(); 
require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
$g  = 	new componente;
$codigo = $_GET["codigo"];
$sesion_elabora=  $g->ConsultaMovimiento($codigo);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 <style type="text/css">
 
	body {
		font-size: 11px;
		color:#000;
	    margin: 2mm 5mm 10mm 5mm;
	}

 
	.tableCabecera{
 	margin:2px 0 2px 0;
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
	 
 </style>
    
</head>

<body>
	
 
	
<table   width="100%">
  <tr>
    <td width="100%" colspan="2" class="titulo"><?php echo utf8_encode ($g->_getEmpresa('razon')); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="MensajeCab">PLATAFORMA DE GESTION DE ADMINISTRACION - FINANCIERA<br> MODULO DE INVENTARIOS - MOVIMIENTO DE BODEGA </td>
  </tr>
   
</table>
	
<table border="0" cellpadding="0" cellspacing="0" class="tableCabecera">
  <tr>
    <td colspan="4" class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle" class="Mensaje">COMPROBANTE DE BODEGA</td>
  </tr> 
  <tr>
    <td class="Mensaje">&nbsp;</td>
    <td class="Mensaje">&nbsp;</td>
    <td align="right" valign="middle" class="Mensaje"><span class="titulo1">NRO.COMPROBANTE</span></td>
    <td class="Mensaje"><span class="titulo"><?php echo  $g->_getId(); ?></span></td>
  </tr>
  <tr>
    <td class="Mensaje">Fecha</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('fecha'); ?></td>
    <td align="right" valign="middle" class="Mensaje">Tipo de Movimiento</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('transaccion'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Unidad Solicita</td>
    <td  width="34%" class="Mensaje"><?php echo $g->_getSolicita('razon'); ?></td>
    <td  width="26%" align="right" valign="middle" class="Mensaje">Nro.Identificacion</td>
    <td  width="27%" class="Mensaje"><?php echo $g->_getSolicita('idprov'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Nro.Comprobante</td>
    <td class="Mensaje" ><?php  echo $g->_getSolicita('comprobante'); ?></td>
    <td class="Mensaje" align="right" >Nro.Tramite Certificacion</td>
    <td class="Mensaje" ><?php echo $g->_getSolicita('id_tramite'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Detalle</td>
    <td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('detalle'); ?></td>
  </tr>
  <tr>
    <td width="13%">&nbsp;</td>
    <td colspan="3"></td>
  </tr>
</table>
<h4>DETALLE DE MOVIMIENTO</h4>
 
<table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-size: 9px" >
      <tbody>
        <tr>
          <td align="center" valign="middle">Codigo</td>
          <td align="center" valign="middle">Detalle</td>
          <td align="center" valign="middle">Unidad</td>
          <td align="center" valign="middle">Cantidad</td>
          <td align="right" valign="middle">Costo Unitario</td>
          <td align="right" valign="middle">Total</td>
        </tr>
		  <?php      $g->_getDetalle($codigo) ;   ?>
       </tbody>
    </table> 

<p>&nbsp;</p>
 
	<table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-size: 9px" >
      <tbody>
        <tr>
          <td align="center" valign="middle">Cuenta</td>
          <td align="center" valign="middle">Detalle</td>
          <td align="center" valign="middle">Clasificador</td>
          <td align="center" valign="middle">Cantidad adquirida</td>
          <td align="right" valign="middle">Costo Promedio</td>
          <td align="right" valign="middle">Costo Total</td>
        </tr>
		  <?php      $g->_getDetalle_conta($codigo) ;   ?>
      </tbody>
    </table> 
 
	
	
<table class="tableFirmas" width="100%" >
  <tr>
    <td class="linea" >&nbsp; </td>
    <td class="linea" >&nbsp; </td>
  </tr>
  <tr>
    <td class="linea1" align="center" valign="middle"><span class="Mensaje"><?php echo $sesion_elabora ?></span></td>
    <td class="linea1" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">ENTREGA</td>
    <td width="50%" class="linea1" align="center" valign="middle">RECIBE</td>
  </tr>
	
</table>
<span style="font-size: 9px"> <?php echo 'Impreso '.$_SESSION['login'] ?></span>	

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
$filename = "ComprobanteInventarios".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>