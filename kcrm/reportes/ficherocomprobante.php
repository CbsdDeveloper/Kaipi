<?php 
ob_start(); 
 require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$idasiento 		= $_GET['a'];
$datos 			=	$gestion->CabAsiento($idasiento);
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

<link rel="stylesheet" type="text/css" href="impresion.css" media="print"  type="text/css"/>
	 
</head>		
<body>
  
<table>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px">COMPROBANTE DE TRANSACCION</td> </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 9px">Nro Comprobante <?php echo $datos['comprobante'] ?></td></tr>
				<tr>
				  <td class="solid"  style="font-size: 9px" width="15%">Fecha</td>
				  <td class="solid"   style="font-size: 9px" width="35%"><?php echo $datos['fecha'] ?></td>
				  <td class="solid" style="font-size: 9px" width="15%">Nro.Asiento</td>
				  <td class="solid"   style="font-size: 9px" width="35%"><?php echo $datos['id_asiento'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Beneficiario</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['proveedor'] ?></td>
				  <td class="solid"  style="font-size: 9px">Identificacion</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Elaborador por</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['sesion'] ?></td>
				  <td class="solid"   style="font-size: 9px">Estado</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td class="solid"  colspan="4" style="font-size: 9px">Detalle</td>
    </tr>
				<tr > <td  class="solid"   colspan="4" style="font-size: 9px"><?php echo $datos['detalle'] ?></td> </tr>
			
 </table>
	<p></p>
 <?php   
 	 $gestion->GrillaAsiento($idasiento); 
 ?>
 <p></p>
 <p></p>
 <p></p>
 <p></p>
 	<table>
					<tr>
					  <td class="solid"   style="padding-bottom: 30px">&nbsp;</td>
					  <td class="solid"  style="padding-bottom: 30px">&nbsp;</td>
					  <td class="solid"  style="padding-bottom: 30px">&nbsp;</td>
					</tr>
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">Elaborado por</td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">Autorizado</td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">Beneficiario</td>
					</tr>
				</table>
</body>
</html>
<?php 
 require_once 'dompdf/dompdf_config.inc.php';
$dompdf = new DOMPDF();
$dompdf->set_paper(DEFAULT_PDF_PAPER_SIZE, 'portrait');
//$dompdf->set_paper('A4', 'landscape'); portrait
$dompdf->load_html(utf8_decode(ob_get_clean()));
$dompdf->render();
$pdf = $dompdf->output();
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';
file_put_contents($filename, $pdf);
$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font("helvetica", "normal");
//$canvas->page_text(420, 575, " {PAGE_NUM} de {PAGE_COUNT}",$font, 7, array(0,0,0));
$canvas->page_text(280, 760, " {PAGE_NUM} de {PAGE_COUNT}",$font, 7, array(0,0,0));
$dompdf->stream($filename, array("Attachment" => false));
 
?>
