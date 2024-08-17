<?php
session_start();
ob_start();

require('kreportes.php');
$gestion   		= 	new ReportePdf;
$codigo 		=   $_GET['id'];
$datos 			=	$gestion->Especie_datos($codigo);

$actividad = $datos['detalle'];
$autoriza = $datos['autorizacion'];
$solicita = $datos['razon'];
$anio  = $datos['anio'];

$gestion->QR_DocumentoDocPermiso($autoriza, $actividad, $solicita, $anio);
?>

<!doctype html>
<html>

<head>

	<meta charset="utf-8">

</head>

<style type="text/css">
	@page {
		size: A4;
		margin: 0;
	}


	* {
		box-sizing: border-box;
		-moz-box-sizing: border-box;
	}

	.page {
		width: 21cm;
		min-height: 29.7cm;
		padding-right: 0.8cm;
		padding-left: 1.0cm;


		/*margin: 1cm auto; */
	}

	.pag1 {
		height: 10cm;
		max-height: 10cm;
		width: 21cm;
		padding-top: 3.5cm;
		/* border: solid; */
		/* border-color: red; */
		/* padding-bottom: 0.8cm; */
	}

	.pag2 {
		height: 10cm;
		max-height: 10cm;
		width: 21cm;
		padding-top: 4.8cm;
		/* border: solid; */
		/* border-color: blue; */
	}

	.Mensaje {
		font-size: 11px;
		color: #000000
	}

	.Mensajep {
		font-size: 14px;
		color: #000000
	}

	.titulo {
		padding-left: 5px;
		padding-bottom: 2px;
		font-size: 10px;
	}

	.titulo1 {
		padding-left: 7px;
		padding-top: 3px;
		padding-bottom: 3px;
		font-size: 11px;
	}

</style>


<body>

	<div class="page" align="center">

		<div class="pag1" align="center">

			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tbody>

					<tr>
						<td>

							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td colspan="3" align="center"><span style="font-size: 22px"><b>PERMISO ANUAL DE FUNCIONAMIENTO</b></span></td>
									</tr>
									<tr>
										<td colspan="3" align="center" style="font-size: 11px">Válido del 01 de enero al 31 de diciembre del presente periodo <b>-<?php echo $datos['anio']; ?></b></td>
									</tr>
									<tr>
										<td colspan="3" style="font-size: 11px" align="justify">El Cuerpo de Bomberos del Gobierno Autónomo Descentralizado Municipal de Santo Domingo en atención a la solicitud presentada y previo informe favorable de inspección <b>N° <?php echo $datos['autorizacion']; ?></b>, procede a emitir el presente <b>PERMISO ANUAL DE FUNCIONAMIENTO</b> en cumplimiento a lo dispuesto en el Art. 35 de la <b>LEY DE DEFENSA CONTRA INCENDIOS.</b></td>
									</tr>
									<tr>
										<td width="90%" colspan="2" style="font-size: 11px" align="left">
											Número de RUC: <b><?php echo $datos['idprov']; ?></b><br>
											Razón Social: <b><?php echo $datos['razon']; ?></b><br>
											Nombre Comercial: <b><?php echo $datos['local_nombrecomercial']; ?></b><br>
											Número de Establecimiento: <b><?php echo $datos['local_numeroestablecimiento']; ?></b><br>
											Dirección: <b><?php echo $datos['direccion'] ?: $datos['direccion_alterna']; ?></b><br>
											Actividades Económicas:<br>
											<?php echo $datos['ciiu_nombre']; ?></b></b>
										</td>
										<td width="10%" style="font-size: 60px" align="center">
											<b><?php echo $datos['anio']; ?></b><br>
											<b style="font-size: 11px"><?php echo $datos['autorizacion']; ?></b>
										</td>
									</tr>
									<tr>
										<td width="33%" align="left">&nbsp;</td>
										<td width="33%" align="center"><img src="../../reportes/firma_gerente.png" width="80" height="75" /></td>
										<td width="33%" align="center"><img width="80" height="80" src='logo_qr.png' /></td>
									</tr>
									<tr>
										<td width="33%" style="font-size: 11px" align="left">
										</td>
										<td width="33%" align="center" style="font-size: 11px">
											ING. HUGO JAVIER PARRA CHAVEZ<br>
											<b>JEFE DEL CB-GADM-SD</b>
										</td>
										<td width="33%" class="titulo" align="center">
											
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right">
							<span style="font-size: 8px;color:#8F8F8F;font-style: italic">
								S:<?php echo $datos['secuencial']; ?> - C:<?php echo $codigo; ?> - <?php $gestion->QR_Firma(); ?><br>
								<?php echo date('Y-m-d h:i:s a') ?>
							</span>
						</td>
					</tr>
				</tbody>
			</table>

		</div>

		<div class="pag2" align="center">

			<table width="90%" border="0" cellspacing="0" cellpadding="0">
				<tbody>

					<tr>
						<td>

							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td colspan="3" align="center"><span style="font-size: 22px"><b>PERMISO ANUAL DE FUNCIONAMIENTO</b></span></td>
									</tr>
									<tr>
										<td colspan="3" align="center" style="font-size: 11px">Válido del 01 de enero al 31 de diciembre del presente periodo <b>-
												<?php echo $datos['anio']; ?>
											</b></td>
									</tr>
									<tr>
										<td colspan="3" style="font-size: 11px" align="justify">El Cuerpo de Bomberos del Gobierno Autónomo Descentralizado Municipal de Santo Domingo en atención a la solicitud presentada y previo informe favorable de inspección <b>N° <?php echo $datos['autorizacion']; ?></b>, procede a emitir el presente <b>PERMISO ANUAL DE FUNCIONAMIENTO</b> en cumplimiento a lo dispuesto en el Art. 35 de la <b>LEY DE DEFENSA CONTRA INCENDIOS.</b></td>
									</tr>
									<tr>
										<td width="90%" colspan="2" style="font-size: 11px" align="left">
											Número de RUC: <b><?php echo $datos['idprov']; ?></b><br>
											Razón Social: <b><?php echo $datos['razon']; ?></b><br>
											Nombre Comercial: <b><?php echo $datos['local_nombrecomercial']; ?></b><br>
											Número de Establecimiento: <b><?php echo $datos['local_numeroestablecimiento']; ?></b><br>
											Dirección: <b><?php echo $datos['direccion'] ?: $datos['direccion_alterna']; ?></b><br>
											Actividades Económicas:<br>
											<?php echo $datos['ciiu_nombre']; ?></b></b>
										</td>
										<td width="10%" style="font-size: 60px" align="center">
											<b><?php echo $datos['anio']; ?></b><br>
											<b style="font-size: 11px"><?php echo $datos['autorizacion']; ?></b>
										</td>
									</tr>
									<tr>
										<td width="33%" align="left">&nbsp;</td>
										<td width="33%" align="center"><img src="../../reportes/firma_gerente.png" width="80" height="75" /></td>
										<td width="33%" align="center"><img width="80" height="80" src='logo_qr.png' /></td>
									</tr>
									<tr>
										<td width="33%" style="font-size: 11px" align="left">
										</td>
										<td width="33%" align="center" style="font-size: 11px">
											ING. HUGO JAVIER PARRA CHAVEZ<br>
											<b>JEFE DEL CB-GADM-SD</b>
										</td>
										<td width="33%" class="titulo" align="center">
											
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right">
							<span style="font-size: 8px;color:#8F8F8F;font-style: italic">
								S:<?php echo $datos['secuencial']; ?> - C:<?php echo $codigo; ?> - <?php $gestion->QR_Firma(); ?><br>
								<?php echo date('Y-m-d h:i:s a') ?>
							</span>
						</td>
					</tr>
				</tbody>
			</table>


		</div>

	</div>

</body>

</html>

<?php

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html((ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador

//$filename = "Anexo".time().'.pdf';
$filename = "PermisoFuncionamiento" . '.pdf';

file_put_contents($filename, $pdf);

$dompdf->stream($filename, array("Attachment" => false));


?>