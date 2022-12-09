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
	
			$gestion->QR_DocumentoDocPermiso($autoriza,$actividad,$solicita,$anio );
?>
 
<!doctype html>
<html>
<head>
	
<meta charset="utf-8">

</head>

<style type="text/css">

	@page { size: A4; margin: 0; }
	
 
	* { box-sizing: border-box; -moz-box-sizing: border-box; } 
	
	.page { 
		width: 21cm; 
		min-height: 29.7cm; 
		padding-right: 0.8cm; 
		padding-left: 1.3cm;
		padding-bottom:  0.8cm;
		padding-top:  0.8cm;	
		/*margin: 1cm auto; */
		} 
	
	.Mensaje{
	font-size: 11px;
 	color:#000000
  	}	
	
	.Mensajep{
	font-size: 14px;
 	color:#000000
  	}	
	
	.titulo{
	padding-left: 5px;
	padding-bottom: 2px;
	font-size: 10px;
  	}
 
	.titulo1{
	padding-left: 7px;
	padding-top: 3px;
	padding-bottom: 3px;
	font-size: 11px;
  	}
   
 </style>
	
	
<body>
 

 
	<div class="page" align="center">

				<table width="85%" border="0" cellspacing="0" cellpadding="0"> <tbody>
 				 
				<tr>
				  <td>
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right"><img width="90" height="90" src='logo_qr.png'/><br>		</td>
				      </tr>
					  <tr>
					    <td colspan="3" style="font-size: 13px" align="justify">Al haber dado cumplimiento con lo que dispone la LEY DE DEFENSA CONTRA INCENDIOS en el Art. 35 que obliga adaptar todas las medidas necesarias para prevenir flagelos.
					      Se otorga el Permiso Anual de Funcionamiento, a: <b><?php echo substr($actividad,0,150).'...' ?> </b>
					      <br> 
					      RUC: <b><?php echo $datos['idprov']; ?> </b>
					      <br>
					      RAZON SOCIAL: <b><?php echo $datos['razon']; ?> </b>
				          <br>
			            DIRECCIÓN:  <b><?php echo $datos['direccion_alterna']; ?> </b></td>
				      </tr>
					  <tr>
						<td align="left"><img src="../../reportes/firma_gerente.png" width="80" height="75"/></td>
						<td align="center">&nbsp;</td> 
						<td align="center">&nbsp;</td>
					  </tr>
					  <tr>
						<td class="titulo" align="left">ING. HUGO JAVIER PARRA CHAVEZ<br>
					    DIRECTOR GENERAL DEL CB-GADM-SD</td>
						<td class="titulo" align="center">&nbsp;</td>
						<td class="titulo" align="center">&nbsp;</td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E"><b>ORIGINAL CONTRIBUYENTE</b></td>
				</tr>
				<tr>
				  <td align="right"><span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?><br> <?php  echo date('Y-m-d h:i:s a') ?></span>	</td>
				</tr>
			  </tbody>
			</table>

		 
				<p>&nbsp;</p>

		 
		<table width="85%" border="0" cellspacing="0" cellpadding="0"> <tbody>
 				 
				<tr>
				  <td>
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right">&nbsp;</td>
				      </tr>
					  <tr>
					    <td colspan="3" align="right"><img width="90" height="90" src='logo_qr.png'/><br>		</td>
				      </tr>
					  <tr>
					    <td colspan="3" style="font-size: 13px" align="justify">Al haber dado cumplimiento con lo que dispone la LEY DE DEFENSA CONTRA INCENDIOS en el Art. 35 que obliga adaptar todas las medidas necesarias para prevenir flagelos.
					      Se otorga el Permiso Anual de Funcionamiento, a: <b><?php echo substr($actividad,0,150).'...' ?> </b>
					      <br> 
					      RUC: <b><?php echo $datos['idprov']; ?> </b>
					      <br>
					      RAZON SOCIAL: <b><?php echo $datos['razon']; ?> </b>
				          <br>
			            DIRECCIÓN:  <b><?php echo $datos['direccion_alterna']; ?> </b></td>
				      </tr>
					  <tr>
						<td align="left"><img src="../../reportes/firma_gerente.png" width="80" height="75"/></td>
						<td align="center">&nbsp;</td> 
						<td align="center">&nbsp;</td>
					  </tr>
					  <tr>
						<td class="titulo" align="left">ING. HUGO JAVIER PARRA CHAVEZ<br>
					    DIRECTOR GENERAL DEL CB-GADM-SD</td>
						<td class="titulo" align="center">&nbsp;</td>
						<td class="titulo" align="center">&nbsp;</td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E"><b> </b></td>
				</tr>
				<tr>
				  <td align="right"><span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?><br> <?php  echo date('Y-m-d h:i:s a') ?></span>	</td>
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
$filename = "PermisoFuncionamiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>