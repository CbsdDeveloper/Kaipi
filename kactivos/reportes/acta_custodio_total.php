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
<link href="css/style.css" rel="stylesheet">
	
</head>		
<body>
	
<div id="header">
  <div  style="padding: 2px"> 
  
    <table width="95%" border="0" class="cabecera_font">
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
	<?php echo $gestion->pie_cliente_final( $datos['nombre']); ?>
</div>
	
<div id="content">
  			    <table width="95%">
				 <tr>
				   <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px">Acta de entrega recepción provisional de bienes</td>
			      </tr>
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px"> 
					  <b>  <?php   	echo strtoupper(trim($datos['clase_documento'])) ?></b>
				 </td>
				</tr>
				 <tr>
				   <td  align="center" style="font-weight: normal;font-size: 12px">
				     	Nro.Referencia  <?php   	echo trim($datos['documento']) ?>
				   </td>
			      </tr>
				 <tr>
				  <td  align="right" style="font-weight: normal;font-size: 10px"> 
					  Nro Tramite: <?php  echo $id ?>  
				 </td>
				</tr>
			   </table>  
 	           
		        <table width="95%" border="0">
				  <tbody> 
					<tr>
					  <td colspan="2" align="justify" style="font-size: 11px">
						  
 						  En Cantón  <?php echo $gestion->_Cab( 'ciudad' ); ?>,  a los  <?php echo $datos['fecha_completa'] ?>, en las oficinas del GAD Municipal de  <?php echo $gestion->_Cab( 'ciudad' ); ?>, ubicadas en  <?php echo $gestion->_Cab( 'direccion' ); ?>, se reúnen por una parte el Encargado de Unidad de Bienes, Responsable administrativo del control de Bienes del GAD de Chimbo, y por otra parte,	el Custodio Administrativo <b><?php  echo $datos['razon'] ?></b>, <?php  echo $datos['cargo'] ?> y el Ing. Oswaldo Pérez Guardalmacén Municipal, con el fin de realizar el acta de entrega – recepción provisional de los bienes que se detallan a continuación, conforme lo indica el REGLAMENTO ADMINISTRACION Y CONTROL DE BIENES DEL SECTOR PUBLICO Acuerdo de la Contraloría General del Estado 67 Registro Oficial Suplemento 388 de 14-dic.-2018 Ultima modificación: 08-abr.-2020, en sus artículos: Art. 21, Art. 41, Art. 44.

						  
					 </td>
				    </tr>
					   
					 
					 
					<tr>
					  <td width="10%">&nbsp;</td>
					  <td width="90%">&nbsp;</td>
				    </tr>
				  </tbody>
				</table>
				<br>
	
			      <?php      $gestion->GrillaBienesCustodios_doc($id); ?>
	
		  		<table width="95%" border="0"  style="font-size: 11px">
				  <tbody>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="justify" style="text-align: justify">Esta entrega recepción se sujeta a las siguientes cláusulas:</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td style="text-align: justify">Primera.- La conservación y el buen uso de los bienes y existencias, será de responsabilidad del usuario final o custodio responsable que los han recibido, a partir de la suscripción de la presente acta, para el desempeño  de sus funciones y labores oficiales que cumple en el GAD de Chimbo.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td style="text-align: justify">Segunda.- El daño, la pérdida, destrucción del bien, por negligencia o mal uso comprobados por la autoridad competente, no imputable al deterioro normal de las cosas, será de responsabilidad del usuario final que lo tiene a su cargo, y de los servidores que de cualquier manera tienen acceso al bien cuando realicen acciones de mantenimiento o reparación por requerimiento propio, salvo que se conozca o se compruebe la identidad de la persona causante de la afectación del bien.</td>
					</tr>
					
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
                    <td style="text-align: justify">Tercera.-En los casos de pérdida o desaparición de los bienes por hurto, robo, abigeato, fuerza mayor o caso fortuito se estará a lo previsto en los artículos 144, 146, 147, 148 y 149 del REGLAMENTO ADMINISTRACION Y CONTROL DE BIENES DEL SECTOR PUBLICO Acuerdo de la Contraloría General del Estado 67 Registro Oficial Suplemento 388 de 14-dic.-2018 Ultima modificación: 08-abr.-2020, debiendo la servidora o servidor encargado de su custodia, comunicar inmediatamente después de conocido el hecho por escrito este hecho al Guardalmacén, al jefe inmediato y a la máxima autoridad del GAD o su delegado, con todos los por menores que fueren del caso.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
                    <td style="text-align: justify">Cuarta. - Cuando se produzca la renuncia, separación, destitución, comisión de servicios o traslado administrativo del servidor municipal, usuario final de los bienes a él asignados, deberá realizar la entrega recepción de los bienes con la intervención del Encargado Unidad de Bienes o su delegado, el delegado de la unidad administrativa correspondiente, y el usuario final del  bien.
                    </td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    <tr>
                    <td style="text-align: justify">Para constancia y fe de lo actuado, firman las partes intervinientes, en unidad de acto en un original y una copia de igual tenor.</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
                    
					<tr>
					  <td align="center">
								 <table width="95%"  style="font-size: 12px">

									 <tr>
									   <td with="50%"  align="center" style="font-weight: normal;font-size: 12px"><b>ELABORADO POR</b></td>
									   <td with="50%"  align="center" style="font-weight: normal;font-size: 12px"><b>RECIBI CONFORME</b></td>
									   </tr>	
									 <tr>
									   <td with="50%"  align="center" style="font-weight: normal;font-size: 10px">
										    <p>&nbsp;</p>
										   <b>
									     <?php  echo 'SRA. ANGELA SANABRIA' ?>
									   	</b>
										  
									 </td>
									   <td    align="center" style="font-weight: normal;font-size: 10px"><b>
										   <p>&nbsp;</p>
									     <?php  echo $datos['razon'] ?>
									   </b>
										 </td>
									   </tr>
												
									 <tr>
									   <td    align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
									   <td    align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
									   </tr>
									 <tr>
									   <td     align="center" style="font-weight: normal;font-size: 10px"><span style="font-weight: normal;font-size: 12px"><b>AUTORIZADO POR</b></span></td>
									   <td   align="center" style="font-weight: normal;font-size: 10px"><span style="font-weight: normal;font-size: 12px"><b>GUARDALMACEN </b></span></td>
									   </tr>
									 <tr>
									   <td     align="center" style="font-weight: normal;font-size: 10px">
										   <p>&nbsp;</p>
										   <b>
									     <?php  echo 'Dirección Administrativa' ?>
									   </b></td>
									   <td    align="center" style="font-weight: normal;font-size: 10px">
										   <p>&nbsp;</p>
										   <b>
									     	<?php  echo 'ING. OSWALDO PEREZ' ?>
										   </b>
										 </td>
									   </tr>
								   </table> 
						
						</td>
				    </tr>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
				  </tbody>
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