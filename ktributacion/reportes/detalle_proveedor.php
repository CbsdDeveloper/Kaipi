<?php 
ob_start(); 
require('resumen_proveedorPdf.php');
$gestion   = 	new ReportePdf; //			 

$mes 		= $_GET['mes'];

$mes 		= str_pad($mes,2,"0",STR_PAD_LEFT);

$anio 		= $_GET['anio'];
$id 		= trim($_GET['id']);

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
			      margin: 10mm 20mm 20mm 20mm;
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
			  td {
				border: 1px solid #ddd;
				padding: 2px;
			  }
		.datos{
			font-size: 8px;
			font-family: verdana, sans-serif;
			font-weight:normal; 
			 
		}
		.titulo{
			font-size: 9px;
			padding: 2px;
		}
  			</style>
</head>		
<body>
	
 	 
  <table border="0" cellpadding="0" cellspacing="0">
			    <tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
				<tr> <td style="padding-bottom: 0px;padding-top: 0px; font-size: 10px">GESTION TRIBUTARIA  </td> </tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 9px">DETALLE POR PROVEEDOR</td></tr>
				<tr> <td style="padding-bottom: 1px;padding-top: 1px;font-size: 9px"><?php echo $Periodo; ?></td> </tr>
			
 </table>
	 
 <div style="padding-bottom: 5px;padding-top: 5px"></div>
 <?php   
 	 $gestion->Grilladetalle_Proveedor_id($anio,$mes,$id ); 
 ?>
 	
</body>
</html>
<?php
 /*

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 
$filename = "DevolucionIVA".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 */
?>
