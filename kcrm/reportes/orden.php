<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    =   trim($_GET['codigo']);
$datos 			=   $gestion->Memorando($id);
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
   <div  style="padding: 7px">
	   <table width="100%" border="0" class="cabecera_font">
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
 	    <div style="padding: 5px" align="center">  
 			  <table width="100%">
				 <tr>
				  <td align="right" style="font-weight: normal;font-size: 13px"> 
					  <b>   MEMORANDO NRO. <?php   	echo trim($datos['nro_memo']) ?> </b>
 				 </td>
				</tr>
				 <tr>
				   <td  align="right" style="font-weight: normal;font-size: 11px"> 
                       <?php  echo $gestion->_Cab( 'ciudad' ).', '.$datos['fecha_completa'] ?>
				   </td>
			    </tr>
				 <tr>
				  <td align="justify" style="font-weight: normal;font-size: 13px"> <?php echo utf8_encode($datos['asunto'])  ?></td>
				</tr>
			   </table>  
  		</div>
</div> 
	
	
</html>
<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();
 
$dompdf->setPaper('A4', 'portrait');  
						  
						  
$dompdf->load_html(utf8_decode( ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 //$dompdf->stream(); // Enviar el PDF generado al navegador
$registro = trim($_SESSION['ruc_registro']);
						  
$filename = "DocMemo".$registro.".pdf";

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>
