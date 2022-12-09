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
					  <td colspan="2">En la ciudad de <?php echo $gestion->_Cab( 'ciudad' ); ?>, a los <?php echo $datos['fecha_completa'] ?>  se reunen:</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">&nbsp;</td>
				    </tr>
					
					<tr> 
					  <td colspan="2" style="text-align: justify" >a.- <b><?php  echo $datos['razon'] ?></b>, <?php  echo $datos['cargo'] ?>, en calidad de responsable directo de los bienes que hoy recibe, y </td>
				    </tr>

				    <tr>
					  <td colspan="2" style="text-align: justify">b.- <b>  <?php echo $datos['sesion'] ?>   </b>, <?php  echo $datos['sesion_cargo'] ?> quien entrega, los bienes de propiedad del Cuerpo de Bomberos del Gobierno Autónomo Descentralizado Municipal de Santo Domingo.</td>
				    </tr>
				    <tr>
					  <td colspan="2" style="text-align: justify">&nbsp;</td>
				    </tr>
					
					<tr>
					  <td colspan="2" style="text-align: justify" >En cumplimiento a lo que indica el Art. 7 OBLIGATORIEDAD, del Reglamento General de Bienes del Sector Público, al tenor de las siguientes cláusulas:</td>
				    </tr>

					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td colspan="2" style="text-align: justify">PRIMERA: ANTECEDENTES. - La Contraloría General del Estado en el Art. 44, del Reglamento General para la Administración, Utilización, Manejo y Control de los Bienes y Existencias del Sector Público, dispone que el guardalmacén de bienes y/o inventarios, entregará los bienes al Usuario Final para las labores inherentes a su cargo o función, en el cual, constarán las condiciones y características de aquellos, de lo cual dejarán constancia en un acta de entrega y recepción.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td colspan="2" style="text-align: justify">Art. 18.- Designación del Custodio. - El titular de cada área de las entidades u organismos comprendidos 
					  en el artículo 1 del presente reglamento, designará al/los Custodio/s Administrativo/s, 
					  según la cantidad de bienes e inventarios de propiedad de la entidad u organismo. </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					
					</tr>
					<tr>
              <td colspan="2" style="text-align: justify">SEGUNDA: OBJETO. - Efectuar la Entrega-Recepción de los bienes propiedad del Cuerpo de Bomberos del GADM SD a reúnen <?php echo $datos['sesion'] ?>.
					 Los bienes entregados son los siguientes:</td>
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
					  <td>&nbsp;</td>
					</tr>
					
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
            <td style="text-align: justify">TERCERA: ACEPTACIÓN. - reúnen, <?php echo $datos['razon']  ?> ,
					  
					  acepta la recepción de los bienes descritos y se compromete a dar cumplimiento a lo que indica
					   el Art. 47, 49, 146 del Reglamento General para la Administración, Utilización, Manejo y Control de los Bienes y 
					   Existencias del Sector Público, a la Norma de control interno en su apartado 406-08 Uso de los bienes de larga duración 
					   y para constancia firman los intervinientes: </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					

                    
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
				    	<?php echo $datos['sesion'] ?>
				   </b></td>
				  <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				     <?php  echo $datos['razon'] ?>
				   </b></td>
			      </tr>
				 <tr>
				   <td  with="33%"  align="center" style="font-weight: normal;font-size: 10px"><b>
				   <?php  echo 'Analista de Control de Bienes ' ?>
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