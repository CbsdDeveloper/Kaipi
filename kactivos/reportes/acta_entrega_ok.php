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
					  <td colspan="2" style="text-align: justify">a.- <b><?php  echo $datos['funcionario_entrega'] ?></b>, <?php  echo $datos['cargo_entrega'] ?> , <?php  echo 'CONTROL DE BIENES' ?>, servidor de la institución que entrega el(los) bienes; y  </td>
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
					  <td style="text-align: justify">  Art.21.-Finalización de la responsabilidad de los custodios Administrativos.-La responsabilidad de los 
					  custodios Administrativos y de   los usuarios finales, respeto de la custodia, cuidado, conservación y buen uso de los bienes concluirá 
					  cuando, conforme a las disposiciones del presente reglamento, se hubieren suscrito las respectivas actas de entrega recepción de egreso 
					  o devolución, según corresponda, o se hubieran procedido a su reposición o restitución de  su valor.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="justify" style="text-align: justify">Esta entrega recepción se sujeta a las siguientes clausulas:</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td style="text-align: justify">Primera.- Los bienes Muebles e Inmuebles, descritos en la presente acta, a partir de la firma, estarán bajo 
					  la responsabilidad, buen uso y cuidado del usuario o custodio final</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td style="text-align: justify">Segunda.- Art.144.-REPOSICION, RESTITUCION, DEL VALOR O REEMPLAZO  DEL BIEN.- Los bienes  de propiedad de las 
					  entidades u organismos comprendidos en el Art.1 del presente reglamento deberán ser restituidos o reemplazados por otros bienes nuevos  de 
					  similares o mejores  características, por parte de los usuarios finales o custodios  Administrativos en los siguientes casos:</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td style="text-align: justify">a)	Cuando los bienes hubieren sufrido daños parciales o totales producto de la negligencia o mal uso comprobados y quedaren inutilizados.</td>
					</tr>
					<tr>
					  <td style="text-align: justify">b)	Cuando los bienes no hubieren sido presentados por el Usuario final o custodio Administrativo al momento de la constatación física</td>
					</tr>
					<tr>
					  <td style="text-align: justify">c)	Cuando los bienes no hubieren sido entregados en el momento de la entrega recepción por cabio de usuario final, Custodio Administrativo o Cesación de funciones  de algunos aquellos </td>
					</tr>
                    <tr>
                    <td style="text-align: justify">d)	Cuando hubiese negativa de la aseguradora  por el reclamo presentado, una vez comprobada legalmente la negligencia en el manejo  del bien por parte del usuario final </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
                    <td style="text-align: justify">La reposición del bien se podrá llevar a cabo, en dinero, al precio actual de mercado o con un bien nuevo de similares o superiores características al bien desaparecido, destruido o inutilizado, previa autorización del titular de la Unidad Administrativa</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
                    <td style="text-align: justify">Tercera.- El daño, perdida, destrucción del bien, por negligencia o su mal uso comprobados por la autoridad competente, no imputable al deterioro normal de las cosas, será de responsabilidad del Usuario Final que lo tiene a su cargo, y de los servidores que de cualquier manera tienen acceso al bien cuando realicen acciones de mantenimiento o reparación por requerimiento propio, salvo que se conozca o se compruebe la identidad de la persona causante de la afectación al bien. </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
                    <td style="text-align: justify">Para constancia y fe de lo actuado, firman las partes intervinientes, en unidad de acto, en un original y una copia de igual tenor. </td>
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
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 12px"><b>RECIBE</b></td>
				   
				 <tr >
				   <td with="33%"  align="center" style="font-weight: normal;font-size: 10px"><p>&nbsp;</p>
			       <p>&nbsp;</p></td>
 				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
			     </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo 'ING. NELLY PACHECO' ?>
				   </b></td>
				  <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['razon'] ?>
				   </b></td>
			      </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				   <?php  echo 'CONTROL DE BIENES' ?>
				   </b></td>
				  <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     CI. <?php  echo $datos['idprov'] ?>
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