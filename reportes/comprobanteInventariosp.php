<?php
session_start();
ob_start();
require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
$g  = 	new componente;
$codigo = $_GET["codigo"];
$sesion_elabora =  $g->ConsultaMovimiento($codigo);
$g->QR_DocumentoDoc($codigo);
$datos = $g->FirmasPie();
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<style type="text/css">
		body {
			font-size: 11px;
			color: #000;
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

		td.solid {
			border-style: solid;
			color: black;
			border-width: thin
		}

		.tableCabecera {
			margin: 2px 0 2px 0;
			border-collapse: collapse;
			border: .40mm solid thin #909090;
			width: 100%
		}

		.tableFirmas {
			margin: 10px 0 10px 0;
			border-collapse: collapse;
			border: .40mm solid thin #909090;
		}

		.titulo {
			padding-left: 10px;
			padding-bottom: 2px;
			font-weight: bold;
			color: #5B5B5B
		}

		.titulo1 {
			padding-left: 10px;
			padding-bottom: 2px;
			color: #5B5B5B
		}

		.MensajeCab {
			padding-left: 10px;
			padding-bottom: 5px;
			font-weight: 100;
			font-size: 11px;
			color: #636363
		}

		.Mensaje {
			font-size: 11px;
			padding-left: 10px;
			padding-right: 5px;
			padding-bottom: 5px;
			color: #000000
		}

		.grillaTexto {
			font-size: 11px;
			padding-left: 10px;
			padding-right: 5px;
			padding-bottom: 5px;
		}

		.Mensaje1 {
			font-size: 12px;
			padding-left: 2px;
			padding-right: 10px;
			padding-bottom: 2px;
			color: #000000
		}

		.linea {
			border: .40mm solid thin #909090;
			padding: 20px;
		}

		.linea1 {
			border: .40mm solid thin #909090;
			padding: 5px;
		}
	</style>

</head>

<body>

	<table class="cabecera_font">
		<tbody>
			<tr>
				<td width="15%" valign="top"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
				<td width="85%" style="padding-left: 10px" valign="top"><?php echo $g->Empresa(); ?><br><?php echo $g->_Cab('ruc_registro'); ?><br>
					<?php echo $g->_Cab('direccion'); ?><br><?php echo $g->_Cab('telefono'); ?><br>Modulo Inventarios<br>
					EXISTENCIAS
				</td>
			</tr>
		</tbody>
	</table>

	<table border="0" cellpadding="0" cellspacing="0" class="tableCabecera">
		<tr>
			<td colspan="4" align="center" valign="middle" class="Mensaje">SOLICITUD REQUERIMIENTO DE BODEGA</td>
		</tr>
		<tr>
			<td colspan="4" align="center" valign="middle" class="Mensaje"></td>
		</tr>
		<tr>
			<td colspan="2" class="Mensaje"><?php echo $g->_getSolicita('bodega'); ?></td>
			<td align="right" valign="middle" class="Mensaje"> Estado</td>
			<td class="Mensaje"><?php echo ( trim($g->_getSolicita('estado')) == 'solicitado' ? 'Borrador' : 'Solicitado'); ?></td>
		</tr>
		<tr>
			<td class="Mensaje">Fecha</td>
			<td class="Mensaje"><?php echo $g->_getSolicita('fecha'); ?></td>
			<td align="right" valign="middle" class="Mensaje">Tipo de Movimiento</td>
			<td class="Mensaje"><?php echo $g->_getSolicita('transaccion'); ?></td>
		</tr>
		<tr>
			<td width="13%" class="Mensaje">Solicita</td>
			<td width="34%" class="Mensaje"><?php echo $g->_getSolicita('razon'); ?></td>
			<td width="20%" align="right" valign="middle" class="Mensaje">Nro.Identificacion</td>
			<td width="33%" class="Mensaje"><?php echo $g->_getSolicita('idprov'); ?></td>
		</tr>
		<tr>
			<td width="13%" class="Mensaje">Transaccion</td>
			<td class="Mensaje"><?php echo  $codigo ?></td>
			<td class="Mensaje" align="right">Unidad</td>
			<td class="Mensaje"><?php echo $g->_getSolicita('unidad'); ?></td>
		</tr>
		<tr>
			<td width="13%" class="Mensaje">Detalle/Justificación</td>
			<td colspan="3" class="Mensaje"><?php echo $g->_getSolicita('detalle'); ?></td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<table width="100%" border="1" cellpadding="2" cellspacing="0" style="font-size: 9px">
		<tbody>
			<tr>
				<td align="center" valign="middle">Codigo</td>
				<td align="center" valign="middle">Detalle</td>
				<td align="center" valign="middle">Unidad</td>
				<td align="center" valign="middle">Cantidad</td>
			</tr>
			<?php $g->_getDetalle_egreso_pedido($codigo);   ?>
		</tbody>
	</table>

	<p>&nbsp;</p>


	<table>
		<tr>
			<td style="padding-bottom: 30px">&nbsp; </td>
		</tr>

		<tr>
			<td style="font-size: 8px" align='justify' valign="middle">
				<b>SOLICITADO POR:</b><br><br>
				<?php echo $g->_getSolicita('razon'); ?> <br>
				<?php echo $g->_getSolicita('unidad'); ?> <br>
				CI. <?php echo $g->_getSolicita('idprov'); ?>
			</td>
		</tr>


		<tr>
			<td style="font-size: 8px" align="justify" valign="middle"><b>NOTA:</b> Las cantidades de los artículos solicitados pueden ser cambiadas por el Guarda Almacén en base a la disponibilidad de los mismos.</td>
		</tr>
	</table>

	<p>&nbsp;</p>
	<img width="80" height="80" src='logo_qr.png' /><br>
	<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php $g->QR_Firma(); ?></span>

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
$filename = "../archivos/inventarios/SolicitudInventario-" . $codigo . '.pdf';

file_put_contents($filename, $pdf);

$dompdf->stream($filename, array("Attachment" => false));



?>