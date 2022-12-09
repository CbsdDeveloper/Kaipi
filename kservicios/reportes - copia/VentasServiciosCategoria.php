<?php 
session_start( );  
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$mes         = $_GET['mes'];
$anio        = $_GET['anio'];
$idproducto  = $_GET['idproducto'];
$idcategoria = $_GET['idcategoria'];

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
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px">RESUMEN MENSUAL DE VENTAS</td> </tr>
				<tr>
				  <td class="solid"    style="font-size: 9px">Periodo</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $anio ?></td>
				  <td class="solid"  style="font-size: 9px">Mes</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $mes ?></td>
  			  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Elaborador por</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $_SESSION['email'] ?></td>
				  <td class="solid"   style="font-size: 9px">Estado</td>
				  <td class="solid"   style="font-size: 9px">APROBADO</td>
    			</tr>
	
				<tr>
 
				  <td class="solid"   style="font-size: 9px">SERVICIO</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $gestion->Servicio($idproducto); ?></td>
				  <td class="solid"   style="font-size: 9px">CATEGORIA</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $gestion->Categoria($idcategoria) ?></td>
    			</tr>
	
 </table>
	<p></p>  
	<div class="datos" >
	  <?php    $gestion->GrillaventaCategoria($idcategoria,$idproducto,$mes,$anio) ;  ?>
	</div> 
</body>
</html>
<?php 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'landscape'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
   
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
?>
