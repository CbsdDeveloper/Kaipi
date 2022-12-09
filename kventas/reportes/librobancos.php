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
$idbancos = $_GET['idbancos'];
$ffecha1 = $_GET['ffecha1'];
$ffecha2 = $_GET['ffecha2']; 
$nombreBanco = $gestion->NombreBanco($idbancos);

$saldo = $gestion->LibroBancosSaldo($idbancos,$ffecha1,$ffecha2);
?>
<!DOCTYPE html>
<html>
	
<head lang="en">

<meta charset="UTF-8">

<link rel="stylesheet" href="impresion.css" />
	 
</head>		

<body>
  
	<table>
			    <tr class="solid" ><td colspan="4" align="center" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
			    <tr class="solid" ><td colspan="4" align="center" style="font-size: 10px">COMPROBANTE DE LIBRO BANCOS</td> </tr>
				<tr class="solid">
				  <td class="solid"    style="font-size: 9px">Cuenta Bancos</td>
				  <td colspan="3" class="solid"  style="font-size: 9px"><?php echo $nombreBanco  ?></td>
	  			</tr>
				<tr class="solid">
				  <td width="20%" class="solid"    style="font-size: 9px">Fecha Inicio</td>
				  <td width="30%" class="solid"  style="font-size: 9px"><?php echo $ffecha1 ?></td>
				  <td width="20%" class="solid"  style="font-size: 9px">Fecha Final</td>
				  <td width="30%" class="solid"   style="font-size: 9px"><?php echo $ffecha2 ?></td>
  			  </tr>
				<tr class="solid">
				  <td width="20%" class="solid"    style="font-size: 9px">Saldo Anterior </td>
				  <td width="30%" class="solid"  style="font-size: 9px"><?php echo $saldo ?></td>
				  <td colspan="2" class="solid"  style="font-size: 9px">&nbsp; </td>
			  </tr>
 </table>
	<p></p>
 <?php   
 	   $gestion->LibroBancos($idbancos,$ffecha1,$ffecha2); 
 ?>
 <p></p>
 	
<img width="70" height="70" src='documento.png'/>	
</body>
</html>
<?php 
 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait');  

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); 

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador

  
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 
 
?>
