<?php 
session_start( );   
ob_start(); 
require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
$g  		= 	new componente;
$codigo 	= $_GET["codigo"];
$g->ConsultaTiket($codigo);
$g->QR_DocumentoDoc($codigo);  
$datos 		= $g->FirmasPie();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 <style type="text/css">
 
	body {
		font-size: 12px;
		color:#000;
	    margin: 2mm 5mm 10mm 5mm;
	}

	  table {
				border-collapse: collapse;
		 		width: 100%
			  }
			  td {
				   border-width: 0.1em;
				   padding: 0.2em;
 			  }
			  td.solid  { 
				  border-style: solid; 
				  color:black;
				 border-width:thin
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
	padding-left: 12px;
	padding-bottom: 2px;
	font-weight: bold;
	color: #5B5B5B
  	}
	 
 .titulo1{
	padding-left: 12px;
	padding-bottom: 2px;
 	color: #5B5B5B
  	}
	 
  .MensajeCab{
	padding-left: 12px;
	padding-bottom: 5px;
	font-weight:450;
	font-size: 11px;
	color:#292828
  	}
 
  .Mensaje{
	font-size: 13px;
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
    <td width="20%" rowspan="2" class="titulo"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80"></td>
    <td width="80%" class="titulo"><?php echo utf8_encode ($g->_getEmpresa('razon')); ?></td>
  </tr>
  <tr>
    <td   class="MensajeCab">PLATAFORMA DE GESTION MESA DE SERVICIOS<br> FORMULARIO DE SOPORTE TECNICO </td>
  </tr>
   
</table>
	
<table border="0" cellpadding="0" cellspacing="0" class="tableCabecera">
  <tr>
    <td colspan="2" class="Mensaje">&nbsp;</td>
    <td align="right" valign="middle" class="Mensaje">Nro.Tiket</td>
    <td class="Mensaje"><span class="titulo"><?php echo   $g->_getSolicita('id_tiket'); ?></span></td>
  </tr>
  <tr>
    <td class="Mensaje">Fecha</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('fecha'); ?></td>
    <td align="right" valign="middle" class="Mensaje">Estado</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('estado'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Solicita</td>
    <td  width="34%" class="Mensaje"><?php echo $g->_getSolicita('unidad'); ?></td>
    <td  width="26%" align="right" valign="middle" class="Mensaje">Categoria</td>
    <td  width="27%" class="Mensaje"><?php echo $g->_getSolicita('categoria'); ?></td>
  </tr>
  <tr> 
    <td width="13%" class="Mensaje">Servicio</td>
    <td colspan="3" class="Mensaje" ><?php echo $g->_getSolicita('tipo_user'); ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Tecnico</td>
    <td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('tecnico'); ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Asunto</td>
    <td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('asunto'); ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Novedad</td>
    <td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('novedad'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Solucion</td>
    <td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('solucion'); ?></td>
  </tr>
</table>
	
<h4>&nbsp; </h4>
 
 <p></p>		
<table>
					<tr>
					  <td   style="padding-bottom: 30px">&nbsp;</td>
					  <td  style="padding-bottom: 30px">&nbsp;</td>
				    </tr>
	
					<tr>
					  <td   style="font-size: 10px" align="center" valign="middle"><?php echo $datos['elaborado'] ?></td>
					  <td  style="font-size: 10px" align="center" valign="middle"><?php echo $g->_getSolicita('nombre'); ?></td>
	 			   </tr>
	
					<tr>
					    <td   style="font-size: 10px" align="center" valign="middle"><?php echo $datos['unidad'] ?></td>
					  <td   style="font-size: 10px" align="center" valign="middle"><?php echo $g->_getSolicita('unidad'); ?></td>
	  				</tr>
	
					 
</table>

<p>&nbsp;</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $g->QR_Firma(); ?></span>	
 

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