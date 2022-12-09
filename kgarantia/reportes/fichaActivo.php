<?php
session_start();
ob_start();
require('kreportes.php');
$gestion   		= 	new ReportePdf;
$id 		    = trim($_GET['codigo']);
$datos 			= $gestion->ficha_bien($id);
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
				<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 3px">NÚMERO TRANSACCION 
				  <?php   echo  $id .'-'.$datos['anio_actual']  ; //trim($datos['movimiento']) ?>  </td>
			</tr>
			<tr>
				<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 3px">FICHA DE INGRESO DE BIENES INSTITUCIONALES</td>
			</tr>
			<tr>
			  <td colspan="4"  style="font-weight: normal;font-size: 11px;padding:3px"> </td>
		  </tr>
			<tr>
				<td colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 3px"> 1. INFORMACION DEL BIEN <?php   //	echo trim($datos['id_bien'])  ?> </td>
			</tr>
			<tr>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">&nbsp;</td>
				<td style="padding: 3px">Código del bien</td>
				<td style="padding: 3px"><?php echo trim($datos['bien']) ?></td>
			</tr>
			<tr>
				<td style="padding: 3px" width="10%">Ingreso</td>
				<td style="padding: 3px" width="50%"><?php echo trim($datos['forma_ingreso']) ?></td>
				<td style="padding: 3px" width="15%">Tipo Bien</td>
				<td style="padding: 3px" width="25%"><?php echo trim($datos['tipo_bien']) ?></td>
			</tr>
			<tr>
				<td style="padding: 3px">Catalogo</td>
				<td style="padding: 3px"><?php echo trim($datos['clase_esigef']) ?></td>
				<td style="padding: 3px">Fecha</td>
				<td style="padding: 3px"><?php echo trim($datos['fecha']) ?></td>
			</tr>
			<tr>
				<td style="padding: 3px">Clasificador</td>
				<td style="padding: 3px"><?php echo trim($datos['clasificador']) ?></td>
				<td style="padding: 3px">Identificador</td>
				<td style="padding: 3px"><?php echo trim($datos['identificador']) ?></td>
			</tr>

			<tr>
				<td style="padding: 3px">Clase Bien</td>
				<td style="padding: 3px"><?php echo trim($datos['clase']) ?></td>
				<td style="padding: 3px">Enlace Contable</td>
				<td style="padding: 3px"><?php echo trim($datos['cuenta']) ?></td>
			</tr>

			<tr>
				<td style="padding: 3px">Estado</td>
				<td style="padding: 3px"><?php echo trim($datos['estado']) ?></td>
				<td style="padding: 3px">Referencia</td>
				<td style="padding: 3px"><?php echo trim($datos['codigo_actual']) ?></td>
			</tr>

			 
		</table>

		<?php $gestion->BienesParametros($datos); ?>
 	
	  <table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" cellpadding="0">
 			<tr>
				<td colspan="2" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px"> 6. INFORMACION COMPLEMENTARIA </td>
			</tr>
			<tr>
				<td width="50%" style="padding: 3px">Fotografia</td>
				<td width="50%" style="padding: 3px">Componentes</td>
			</tr>
			<tr>
				<td width="50%" style="padding: 5px"><img src="../../archivos/activos/<?php echo trim($datos['archivo']) ?>" width="230px" height="100px" /></td>
				<td width="50%" align="left" valign="top" style="padding: 5px"> <?php $gestion->bien_componente($_GET['codigo']); ?></td>
			</tr>

		</table>


		<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px" border="0" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td width="400%" colspan="4" bgcolor="#EDEDED" style="font-weight: normal;font-size: 11px;padding: 6px">RESPONSABILIDAD DEL CUSTODIO</td>
				</tr>
				<tr>
					<td colspan="4" style="padding: 3px">El custodio acepta que el (los) bienes descritos en el presente documento se encuentra bajo su responsabilidad y serán incluidos en la base de datos de bienes.</td>
				</tr>
				<tr>
				  <td colspan="4">&nbsp;</td>
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
								<td with="50%" align="left" style="font-weight: normal;font-size: 10px"><b>
									<?php echo $firmas['b10'] ?><br><?php echo $firmas['b11'] ?>
									</b></td>
								<td with="40%" align="center" style="font-weight: normal;font-size: 10px"> </td>
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