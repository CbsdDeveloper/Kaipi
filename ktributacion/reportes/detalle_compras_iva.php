<?php 
ob_start(); 
require('devolucion_comprasPdf.php');
$gestion   = 	new ReportePdf; //			 
$mes 		= $_GET['mes'];
$anio 		= $_GET['anio'];
$Periodo 	= 'PERIODO '.$mes .' - '. $anio ;
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
	<style>
           body{
 				  font-family: verdana, sans-serif;
					color: #000;
					background: #fff;
 				}
				.nombre{
					border-bottom: 1px solid cornsilk;
					font-size: 24px;
					font-family: Courier, "Courier new", monospace;
					font-style: italic;
				}
		    .encabezado{
				border="0"
             }
			 table {
				border-collapse: collapse;
				width: 100%
			  }
			/*  td {
				border: 1px solid #ddd;
				padding: 2px;
			  }*/
			 th {
				border: 1px solid #ddd;
				background-color:#ECECEC ;
				padding: 2px;
			  }
		.datos{
			font-size: 7px;
			font-family: verdana, sans-serif;
			font-weight:normal; 
			 
		}
		.etiqueta{
			font-size: 7px;
			font-family: verdana, sans-serif;
			font-weight:normal; 
			 
		}
		.titulo{
			font-size: 8px;
			padding: 2px;
		}
		.tabla {
 	 border: 0;
	 margin: 1px;	
	 padding: 1px;
  	}
  			</style>
</head>		
<body>
 <div style="padding: 15px">
  <table border="0"  width="100%" cellpadding="0" cellspacing="0" class="tabla">
			    <tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
				<tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 8px">GESTION TRIBUTARIA KAIPI</td> </tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 8px">RESUMEN COMPRAS  IVA</td></tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 8px"><?php echo $Periodo; ?></td> </tr>
			
 </table>
 <div style="padding-bottom: 5px;padding-top: 5px"></div>
 <?php   
  $gestion->GrillaIvaResumen($anio,$mes); 
 ?>
 <br> <br><br><br>
	  		<table>
				  <tbody>
					<tr>
					  <td style="padding-bottom: 30px">&nbsp;</td>
					  <td style="padding-bottom: 30px">&nbsp;</td>
					</tr>
					<tr>
					  <td style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">REPRESENTANTE LEGAL</td>
					  <td style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">CONTADORA GENERAL</td>
					</tr>
				  </tbody>
				</table>
</div>
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
$filename = "DevolucionIVA".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

?>
