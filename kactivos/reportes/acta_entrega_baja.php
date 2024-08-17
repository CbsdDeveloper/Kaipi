<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['id']);
$datos 			= $gestion->Acta_entrega($id);
 
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
  <div  style="padding: 2px">
	   <table width="90%" border="0" class="cabecera_font" >
		  <tbody>
			<tr>
			  <td width="15%" valign="top"><img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="85%" valign="top"><?php echo $gestion->Empresa(); ?><br><?php echo $gestion->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $gestion->_Cab( 'direccion' ); ?><br><?php echo $gestion->_Cab( 'telefono' ); ?>
				</td>
			</tr>
		  </tbody>
		</table>
   </div> 
 </div>
 
<div id="footer">
	<?php echo $gestion->pie_cliente( $datos['nombre']); ?>
</div>
	
<div id="content">

	<table style="border-collapse: collapse; border: 1px solid #AAAAAA;font-weight: normal;font-size: 10px; padding-left:60px;padding-right:60px;text-align: center;" border="0" width="95%" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="4" style="font-weight:bold;font-size: 12px;padding: 3px">Baja de Bienes N° 
			<?php   echo  $id  ; ?>  </td>
		</tr>
	</table>
	
	  <div  style="padding-left:60px;padding-right:60px;">
				 <?php      $gestion->firma_baja('AC-BB',$datos); ?>
				 <?php      $gestion->GrillaBienesBaja($id); ?> 
				 <?php      $gestion->firma_baja('AC-AB',$datos); ?>
		  
		 		 	<?php  echo $datos['adicional'] ?>
    </div> 
 </div> 
	
	
</html>
<?php 
	
  ini_set('memory_limit', '384M');
  ini_set('max_execution_time', 300);
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html((ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
$registro = trim($_SESSION['ruc_registro']);
						  
$filename = "DocMemo".$registro.".pdf";
 
 						  
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
