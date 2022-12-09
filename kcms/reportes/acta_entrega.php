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
	   <table width="90%" border="0" class="cabecera_font">
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
  			    <table width="90%">
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px"> 
					  <b>  <?php   	echo strtoupper(trim($datos['clase_documento'])) ?></b>
				 </td>
				</tr>
				 <tr>
				   <td  align="center" style="font-weight: normal;font-size: 12px">
				     	Nro.Acta <?php   	echo trim($datos['documento']) ?>
				   </td>
			      </tr>
				 <tr>
				  <td  align="right" style="font-weight: normal;font-size: 10px"> 
					  Nro Tramite: <?php  echo $id ?>  
				 </td>
				</tr>
			   </table>  
 	           
		        <table width="90%" border="0">
				  <tbody> 
					<tr>
					  <td colspan="2">En la ciudad de <?php echo $gestion->_Cab( 'ciudad' ); ?>, a los <?php echo $datos['fecha_completa'] ?>  comparecen:</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">&nbsp;</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">a.- <b><?php  echo $datos['funcionario_entrega'] ?></b>, <?php  echo $datos['cargo_entrega'] ?>, servidor de la institución que entrega el(los) bienes; y  </td>
				    </tr>
					<tr>
					  <td colspan="2">&nbsp;</td>
				    </tr>
					<tr> 
					  <td colspan="2" style="text-align: justify" >b.- <b><?php  echo $datos['razon'] ?></b>, <?php  echo $datos['cargo'] ?>, servidor de la institución que recibe el(los) bienes en representacion de la <?php echo $gestion->_Cab( 'razon' ); ?>, según el documento habilitante.</td>
				    </tr>
					<tr>
					  <td width="10%">&nbsp;</td>
					  <td width="90%">&nbsp;</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">Quienes, en cumplimiento del inciso final del artículo 62 del Reglamento General Sustitutivo para el Manejo y Administración de Bienes del Sector Público, suscriben la presente ACTA DE ENTREGA-RECEPCIÓN de los siguientes bienes:</td>
				    </tr>
				  </tbody>
				</table>
				<br>
	
			   <?php      $gestion->GrillaBienes($id); ?>
	
		  		<table width="90%" border="0">
				  <tbody>
					<tr>
					  <td style="text-align: justify">&nbsp;</td>
				    </tr>
					<tr>
					  <td style="text-align: justify">Se deja constancia que los bienes que se reciben son nuevos y por lo tanto se encuentran en excelente estado de funcionamiento, obligándose la entidad receptora de los equipos a su conservación, de acuerdo con su naturaleza y conforme lo disponen los artículos 2080 y 2081 de la Codificación al Código Civil; y, a restituirlo a la terminación del contrato de comodato suscrito.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="justify" style="text-align: justify">Para constancia de su aceptación las partes suscriben el presente instrumento en dos ejemplares de igual tenor y efecto, en la ciudad de [nombre del lugar de suscripción y fecha]</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
				  </tbody>
				</table>
 
		        <table width="90%">
				 
				 <tr >
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 12px"><b>ENTREGA</b></td>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 12px"><b>RECIBE</b></td>
			      </tr>
				 <tr >
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 10px"><p>&nbsp;</p>
			       <p>&nbsp;</p></td>
 				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
			     </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['funcionario_entrega'] ?>
				   </b></td>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['razon'] ?>
				   </b></td>
			      </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     CI. <?php  echo $datos['idprov_entrega'] ?>
				   </b></td>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     CI. 
				     <?php  echo $datos['idprov'] ?>
				   </b></td>
			      </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 11px">&nbsp;</td>
 				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 11px">&nbsp;</td>
			     </tr>
				  
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

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
$registro = trim($_SESSION['ruc_registro']);
						  
$filename = "DocMemo".$registro.".pdf";
 
 						  
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
