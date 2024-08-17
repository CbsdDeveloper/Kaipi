<?php
session_start();
ob_start();
require('kreportes.php');
$gestion   		= 	new ReportePdf;
$tramite		    = trim($_GET['a']);
$factura 		    = trim($_GET['b']);
$ruc		        = trim($_GET['c']);

$datos 			    = $gestion->ficha_bien_compra($tramite,$factura ,$ruc);
$datos1 			= $gestion->ficha_bien_tramite($tramite);

?>
<!DOCTYPE html>
<html>

<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="css/style.css" rel="stylesheet">

</head>

<body>

	<div id="header">
 			 <table width="90%"  border="0" style="border-collapse: collapse; border: 1px solid #AAAAAA;">
					  <tr>
					    <td style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 10px" width="11%" align="left" valign="top">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
						</td>
						<td colspan="3" align="center" style="font-size: 10px">
							<?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?>
						</td>
							 <td width="6%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
			   </tr>
		  </table>
 	</div>

	<div id="footer">
		<?php echo $gestion->pie_cliente($datos['nombre']); ?>
	</div>

	<div id="content">
		
		 	<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="90%" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 6px">NÚMERO TRAMITE 
				  <?php   echo $tramite.'-'.$datos['anio_adquisicion'] ;?>  </td>
			</tr>
			<tr>
				<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 6px">CONTROL DE INGRESO DE  BIENES INSTITUCIONALES</td>
			</tr>
			<tr>
				<td colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px"> 1. INFORMACION PROCESO DE ADQUISICION DE COMPRAS </td>
			</tr>
			<tr>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">Tramite</td>
				<td style="padding: 3px"><?php echo $tramite ?></td>
			</tr>
			<tr>
				<td style="padding: 3px" width="15%">Nro.Factura</td>
				<td style="padding: 3px" width="45%"><?php echo trim($datos['factura']) ?></td>
				<td style="padding: 3px" width="15%">Fecha Factura</td>
				<td style="padding: 3px" width="25%"><?php echo trim($datos['fecha_comprobante']) ?></td>
			</tr>
			<tr>
				<td style="padding: 3px">Identificacion</td>
				<td style="padding: 3px"><?php echo trim($datos['idproveedor']) ?> </td>
				<td style="padding: 3px">Fecha Registro</td>
				<td style="padding: 3px"><?php echo trim($datos['fecha']) ?></td>
		    </tr>
			<tr>
			  <td style="padding: 3px">Forma Ingreso</td>
			  <td style="padding: 3px"><?php echo trim($datos['forma_ingreso']) ?></td>
			  <td style="padding: 3px">Fecha Adquisicion</td>
			  <td style="padding: 3px"><?php echo trim($datos['fecha_adquisicion']) ?></td>
			  </tr>
			<tr>
				<td style="padding: 3px">Proveedor</td>
				<td colspan="3" style="padding: 3px"><?php echo trim($datos['proveedor']) ?> </td>
			</tr>

			<tr>
			  <td style="padding: 3px">Solicita</td>
			  <td style="padding: 3px"><?php echo trim($datos1['unidad']) ?></td>
			  <td style="padding: 3px">Comprobante</td>
			  <td style="padding: 3px"><?php echo trim($datos1['comprobante']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">Detalle</td>
			  <td colspan="3" style="padding: 3px"><?php echo trim($datos1['detalle']) ?></td>
		  </tr>
			<tr>
				<td style="padding: 3px">&nbsp; </td>
				<td style="padding: 3px">&nbsp; </td>
				<td style="padding: 3px">&nbsp; </td>
				<td style="padding: 3px">&nbsp;</td>
			</tr>

		</table>
		
		    <h4>Resumen de bienes adquiridos</h4>
   
 			<?php $gestion->GrillaBienes_Compra($tramite,$factura ,$ruc); ?>
	
			<hr>
	
		    <h4>Afectación Presupuestaria</h4>
		
		   <?php $gestion->GrillaCompromisoTra($tramite); ?>
		
		<div style="padding: 30px">&nbsp;</div>
		  <p>
		 <?php     $gestion->firma_reportes('AC-FC'); ?>
		</p>
</div>


</html>
<?php
 
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf = new DOMPDF();

$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html((ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 
$registro = trim($_SESSION['ruc_registro']);

$filename = "ResumenBienesTramite-" . $tramite . ".pdf";
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>