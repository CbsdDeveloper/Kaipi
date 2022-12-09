<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['id']);
$datos 			= $gestion->ActivosCustodios($id);
 
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link href="css/styleh.css" rel="stylesheet">
	
</head>		
<body>
	
<div id="header">
	
 	   <table width="100%" border="0" class="cabecera_font">
		  <tbody>
			<tr>
			  <td width="15%" valign="top">
				  <img align="absmiddle"  src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
				  <td width="85%" valign="top"><?php echo $gestion->Empresa(); ?><br><?php echo $gestion->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $gestion->_Cab( 'direccion' ); ?><br><?php echo $gestion->_Cab( 'telefono' ); ?>
				</td>
			</tr>
		  </tbody>
		</table>
   
	
 </div>
 
<div id="footer">
	<?php echo $gestion->pie_cliente( $datos['razon']); ?>
</div>
	
<div id="content">
	
  <table width="100%">
				 <tr>
				   <td align="center" bgcolor="#EDEDED" style="font-weight:800;font-size: 12px">FICHA PERSONAL DE BIENES ASIGNADOS</td>
    </tr>
				 <tr>
				  <td> 
					  <b><span style="font-weight: normal;font-size: 12px"><?php  echo strtoupper(trim($datos['unidad'])) ?></span></b><br>
					     <span style="font-weight: normal;font-size: 10px"><?php  echo strtoupper(trim($datos['regimen'])) ?><br>
					     <?php  echo 'IDENTIFICACION: '.strtoupper(trim($datos['idprov'])) ?><br>
					     <?php  echo 'FUNCIONARIO: '.strtoupper(trim($datos['razon'])) ?><br>
					     <?php  echo 'CARGO: '.strtoupper(trim($datos['cargo'])) ?><br>
					     <?php  echo 'UBICACION: '.strtoupper(trim($datos['ciudad'])) ?><br></span>
 					 
				 </td>
				</tr>
			   </table>
	
<br>
	
			   <?php      $gestion->GrillaBienesCustodios($id); ?>
	
		  	 
		        <table width="90%">
				 
				 <tr >
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 10px">
			       <p>&nbsp;</p></td>
			      </tr>
				 <tr>
				   <td  with="33%"  style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['razon'] ?>
				   </b></td>
			      </tr>
				 <tr>
				   <td  with="33%"  style="font-weight: normal;font-size: 10px"><b>
				     CI. <?php  echo $datos['idprov'] ?>
				   </b></td>
			      </tr>
				 
				  
			   </table> 
 
	
 </div> 
	
	
</html>
<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'landscape'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html((ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
$registro = trim($_SESSION['ruc_registro']);
						  
$filename = "DocMemo".$registro.".pdf";
 
 						  
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
