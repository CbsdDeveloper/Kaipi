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
					  <td colspan="2">En la ciudad de <?php echo $gestion->_Cab( 'ciudad' ); ?>, a los <?php echo $datos['fecha_completa'] ?>  se deja constancia que:</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">&nbsp;</td>
				    </tr>
					
					<tr>
					  <td colspan="2" style="text-align: justify">El (los) bienes que se detallan a continuación, se encuentran fuera de uso por <?php echo $datos['motivo'] ?>, motivo por el cual se realiza la Baja de Bienes.</td>
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
					  <td style="text-align: justify">Art. 80.- Inspección técnica de verificación de estado.- Sobre la base de los resultados de la constatción física efectuada, en cuyas conclusiones se determine la existencia de bienes o inventarios inservibles, obsoletos o que hubieren dejado de usarse, se informará al titular de la entidad u organismo, o su delegado para que autorice el correspondiente proceso de baja. Cuando se trate de equipos informáticos, eléctricos, electrónicos, maquinaria y/o vehículos, se adjuntará el respectivo informe técnico, elaborados por la unidad correspondiente considerando la naturaleza del bien. Si en el informe técnico se determina que los bienes o inventarios todavía son necesarios para la entidad u organismo, concluirá el trámite para aquellos bienes y se archivará el expediente. Caso contrario, se procederá de conformidad con las normas señaladas para los procesos de remate, venta, permutas, transferencia gratuita, traspaso, chatarrización, reciclaje, destrucción, según corresponda, observando para el efecto, las características de registros señaladas en la normativa pertinente, Cuando se presuma de la existencia de bienes que tengan valor histórico, se evaluará lo perceptuado en la Ley Orgánica de Cultura.</td>
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
					<tr>
					  <td>&nbsp;</td>
				    </tr>
				  </tbody>
				</table>
 
		        <table width="90%">
				 
				 
				 <tr >
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 10px"><p>&nbsp;</p>
			       <p>&nbsp;</p></td>
 				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
			     </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['funcionario_entrega'] ?>
				   </b></td>
				 
			      </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     Unidad Responsable
				   </b></td>
				   
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 11px">&nbsp;</td>
 				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 11px">&nbsp;</td>
			     </tr>
				  
			   </table> 
  
				<?php  echo $datos['adicional'] ?>
	
	
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
