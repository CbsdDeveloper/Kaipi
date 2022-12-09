<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['id']);
$datos 		    = $gestion->Distributivo_personal($id);
 
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
	  
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tbody>
					<tr>
					  <td width="65%">&nbsp;</td>
					  <td width="35%">&nbsp;</td>
					</tr>
					<tr>
					  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
						    <td width="9%" rowspan="4" valign="middle"  align="right"><img align="absmiddle"  src="barra.png" /></td>
						    <td width="91%" align="left">&nbsp;</td>
					      </tr>
						  <tr>
						    <td align="left" style="font-size:15px;color: #3E4CAD;font-family:Helvetica, Arial"><b>DIRECCION DE TALENTO HUMANO</b></td>
					      </tr>
						  <tr>
						    <td align="left" style="font-size:15px;color: #3E4CAD;font-family:Helvetica, Arial">DISTRIBUTIVO ESTACION</td>
					      </tr>
						  <tr>
						    <td align="left"><span style="font-weight: normal;font-size: 10px">
						      <?php   	echo str_pad($id, 5, "0", STR_PAD_LEFT) .'-'. $datos['anio']   ?>
						    </span></td>
					      </tr>
					    </tbody>
					  </table></td>
					  <td align="right"><img align="absmiddle"/><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
					</tr>
					 
				  </tbody>
	</table>
	  
	  
	  
	  
	  
	  
	  
  </div> 
 </div>
 
<div id="footer">
 
</div>
	
<div id="content">
	
	 
  <table width="90%" align="center">
				 <tr>
				  <td  align="left" style="font-weight: normal;font-size: 10px;font-weight: 800"><b>PSI.ORG<br>
				    PAZMIÑO ORELLANA JORGE LUIS<br>
				    DIRECTOR DE TALENTO HUMANO, ENCARGADO<br>
				    CUERPO DE BOMBEROS DEL GADM  DE SANTO DOMINGO</b><br>
		           <br></td>
				</tr>
			   </table>  
 	           
		        <table width="90%" align="center" border="0">
				  <tbody>
					<tr>
					  <td>Fecha</td>
					  <td width="30%"><?php  echo $datos['fecha'] ?></td>
					  <td width="20%" align="right">Estado</td>
					  <td width="20%"><?php  echo $datos['estado'] ?></td>
				    </tr>
					<tr>
					  <td width="20%">Documento</td>
					  <td colspan="3"><?php  echo $datos['doccumento'] ?></td>
				    </tr>
					  <tr>
					  <td>Unidad Operaciones</td>
					  <td colspan="3"><?php  echo $datos['acompleto'] ?></td>
				    </tr>
					   <tr>
					  <td>SubJefe de Bomberos</td>
					  <td colspan="3"><?php  echo $datos['ocompleto'] ?></td>
				    </tr>
					<tr>
					  <td colspan="4" style="font-weight: bold" align="justify"><?php  echo $datos['detalle'] ?></td>
				    </tr>
					 
				  </tbody>
				</table>
				<br>
		 		 
				   <?php  $gestion->Distributivo_dpersonal($id) ?>
   
 
	
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

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
$registro = trim($_SESSION['ruc_registro']);
						  
$filename = "DocMemo".$registro.".pdf";
 
 
						  
$dompdf->stream($filename, array("Attachment" => false));

 
?>
