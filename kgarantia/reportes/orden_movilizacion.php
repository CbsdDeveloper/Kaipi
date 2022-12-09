<?php
session_start();
ob_start();
require('kreportes.php');
$gestion   		= 	new ReportePdf;
$id 		    = trim($_GET['codigo']);
$datos 			= $gestion->ficha_orden($id);
$firmas 		= $gestion->firmas();
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
 			 <table width="100%"  border="0" style="border-collapse: collapse; border: 1px solid #AAAAAA;">
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
		<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="4" align="center" style="font-weight:bold;font-size: 12px;padding: 3px">ORDEN DE MOVILIZACION
				  <?php   echo  $id .'-'.$datos['anio']   ?>  </td>
			</tr>
			<tr>
				<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 3px">DATOS DE EMISION DE LA ORDEN</td>
			</tr>
			<tr>
			  <td colspan="4"  style="font-weight: normal;font-size: 11px;padding:3px"> </td>
		  </tr>
			<tr>
				<td colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 3px"> 1. INFORMACION PERSONAL  </td>
			</tr>
			<tr>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">Ciudad</td>
				<td style="padding: 3px"><?php echo $gestion->_Cab( 'ciudad' ) ?></td>
			</tr>
			<tr>
				<td style="padding: 3px" width="20%">Fecha Orden</td>
				<td style="padding: 3px" width="30%"><?php echo trim($datos['fecha_orden']) ?></td>
				<td style="padding: 3px" width="20%">&nbsp; </td>
				<td style="padding: 3px" width="30%">&nbsp; </td>
			</tr>
			<tr>
				<td style="padding: 3px">Solicita</td>
				<td style="padding: 3px"><?php echo trim($datos['razon']) ?></td>
				<td style="padding: 3px">Unidad</td>
				<td style="padding: 3px"><?php echo trim($datos['unidad']) ?></td>
			</tr>
			<tr>
			  <td style="padding: 3px">&nbsp;</td>
			  <td style="padding: 3px">&nbsp;</td>
			  <td style="padding: 3px">Fecha Salida</td>
			  <td style="padding: 3px"><?php echo trim($datos['fecha_orden']) ?> Hora: <?php echo trim($datos['hora_salida']) ?></td>
	      </tr>
			<tr>
			  <td style="padding: 3px">&nbsp;</td>
			  <td style="padding: 3px">&nbsp;</td>
			  <td style="padding: 3px">Fecha Llegada</td>
			  <td style="padding: 3px"><?php echo trim($datos['fecha_llegada']) ?> Hora: <?php echo trim($datos['hora_llegada']) ?></td>
	      </tr>
			<tr>
				<td style="padding: 3px">Motivo</td>
				<td colspan="3" style="padding: 3px"><?php echo trim($datos['motivo_traslado']) ?>  </td>
			</tr>

			<tr>
				<td style="padding: 3px">Nro.Ocupantes</td>
				<td style="padding: 3px"><?php echo trim($datos['nro_ocupantes']) ?></td>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">&nbsp;</td>
			</tr>

			<tr>
			  <td style="padding: 3px">Lugar de Origen</td>
			  <td style="padding: 3px"><?php echo trim($datos['origen']) ?></td>
			  <td style="padding: 3px">Lugar de Destino</td>
			  <td style="padding: 3px"><?php echo trim($datos['destino']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">Kilometraje Inicio</td>
			  <td style="padding: 3px"><?php echo trim($datos['sale_km']) ?></td>
			  <td style="padding: 3px">Kilometraje Fin</td>
			  <td style="padding: 3px"><?php echo trim($datos['llega_km']) ?></td>
		  </tr>
		</table> 
		<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" cellpadding="0">
 			<tr>
				<td colspan="2" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px"> INFORMACION CONDUCTOR </td>
			</tr>
			<tr>
			  <td width="9%" style="padding: 3px">NOMBRES</td>
			  <td width="91%" style="padding: 3px"><?php echo trim($datos['chofer']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">IDENTIFICACION</td>
			  <td style="padding: 3px"><?php echo trim($datos['id_prov_chofer']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">CARGO</td>
			  <td style="padding: 3px"><?php echo 'CONDUCTOR';//trim($datos['cargo']) ?></td>
		  </tr>
			<tr>
			 <td colspan="2" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px"> INFORMACION VEHICULO </td>
		  </tr>
			<tr>
			  <td style="padding: 3px">DESCRIPCION VEHICULO</td>
			  <td style="padding: 3px"><?php echo trim($datos['descripcion']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">PLACA</td>
			  <td style="padding: 3px"><?php echo trim($datos['placa_ve']) ?></td>
		  </tr>
			<tr>
			  <td style="padding: 3px">&nbsp;</td>
			  <td style="padding: 3px">&nbsp;</td>
		  </tr>
	  </table>


		<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
				  <td width="6400%" colspan="4">&nbsp;</td>
			  </tr>
				<tr>
				  <td colspan="4">
					
					<table width="100%" border="0" >
 							<tr>
								<!-- <td with="10%"></td> -->
								<td with="50%" align="center" style="font-weight: normal;font-size: 10px;"> </td>
								<td with="50%" align="center" style="font-weight: normal;font-size: 10px;">&nbsp;</td>
							</tr>
							 
						 <tr>
								<!-- <td with="10%"></td> -->
								<td colspan="2" align="center" style="font-weight: normal;font-size: 10px;" with="50%"> Tcrnl. Hugo Astudillo Torres<BR>AUTORIZADO</td>
							</tr>
							 
					</table>
				  </td>
			  </tr>
				 
		  </tbody>
	  </table>
 
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

$filename = "DocMemo" . $registro . ".pdf";
 
$dompdf->stream($filename, array("Attachment" => false));
 

?>