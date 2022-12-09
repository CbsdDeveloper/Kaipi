<?php 
session_start( );  
include('phpqrcode/qrlib.php'); 
	$content = $_SESSION['ruc_registro'];
    $name = $_SESSION['razon'] ; 
    $elaborador = $_SESSION['login']; 
    $sesion = $_SESSION['email'];
     
    // we building raw data 
    $codeContents  .= 'Comprobante Financiero'."\n"; 
    $codeContents .= $name."\n"; 
	$codeContents .= 'Elaborado '.$elaborador."\n"; 
    $codeContents .= 'https://g-kaipi.com/'."\n"; 

 
 
QRcode::png($codeContents,"documento.png",QR_ECLEVEL_L,10,2);

ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$idasiento 		=   $_GET['id_co_caja'];
$fanio 		=   $_GET['fanio'];
$fmes 		=   $_GET['fmes'];
$cuenta 	=   $_GET['cuenta'];
 
$datos 			=	$gestion->CabCaja($idasiento);
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

 	
	 <link rel="stylesheet" href="impresion.css" />
	
	 
</head>		
<body>
  
<table>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px">RESUMEN DE CAJA CHICA - BENEFICIARIOS </td> </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 9px">Referencia <?php echo $_GET['id_co_caja'].' - '. $_SESSION['ruc_registro'] ?></td></tr>
				<tr>
				  <td class="solid"  style="font-size: 9px" width="20%">Fecha</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['fecha'] ?></td>
				  <td class="solid" style="font-size: 9px" width="20%">Nro.Cuenta</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['cuenta'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Periodo</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['anio'] ?></td>
				  <td class="solid"  style="font-size: 9px">Mes</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['mes'] ?></td>
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
 	 $gestion->GrillaResumenCuentasCaja($fanio,$fmes,$cuenta); 
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
<p></p>
 <p></p>	
<img width="70" height="70" src='documento.png'/>	
</body>
</html>
<?php 
 

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador


 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
?>
