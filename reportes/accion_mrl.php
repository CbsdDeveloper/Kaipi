<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['id']);
$datos 		    = $gestion->Accion($id);

$gestion->QR_DocumentoDoc($id);  
 
 
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
	  
	   <table width="100%" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 10px" >
		  <tbody>
			<tr>
			    <td width="15%" valign="top" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 5px">
				  <img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="82" height="62"></td>
		      <td width="50%" valign="baseline" style="padding: 5px">
				  <?php echo $gestion->Empresa(); ?><br><?php echo $gestion->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $gestion->_Cab( 'direccion' ); ?><br><?php echo $gestion->_Cab( 'telefono' ); ?>
				</td>
			  <td width="35%" valign="top"  style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 5px">DIRECCION DE TALENTO HUMANO <br>
			    <b>ACCION DE PERSONAL<br> 
		      Fecha:<?php echo $datos['fecha'] ?> <br>Nro: <?php echo $id  ?> </b></td>
		    </tr>
		  </tbody>
		</table>
   </div> 
	
 </div>
 
<div id="footer">
	
	<img width="60" height="60" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
 
</div>
	
<div id="content">
	
	
	
  			    <table width="100%" border="0" cellpadding="0" cellspacing="0">
					 <tr>
					  <td colspan="2">&nbsp;</td>
					</tr>
					<tr>
					  <td colspan="2" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" >
							 	 <table  width="85%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding: 10px">
									  <tr>
										<td width="20%" align="right">DECRETO</td>
										<td width="2%"> </td>  
										<td style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 2px" align="center" width="5%"><?php echo $datos['D'] ?> </td>
										<td width="5%"> </td>
										<td width="20%" align="right">ACUERDO</td>
										 <td width="2%"> </td> 
										<td style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 2px" align="center"width="5%"><?php echo $datos['A'] ?> </td>
										<td width="5%"> </td>
										<td width="20%" align="right">RESOLUCION</td>
										<td width="2%"> </td>  
										<td style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px; padding: 2px" align="center"width="5%"><?php echo $datos['R'] ?> </td>
									  </tr>
							 </table>
					  </td>
					</tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > <p><b><?php echo $datos['razon'] ?> </b></p> </td>
				  </tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 9px;" >APELLIDO Y NOMBRE</td>
				    </tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > 
				     	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td align="center" style="padding: 10px" ><?php echo $datos['idprov'] ?> </td>
								  <td align="center" style="padding: 10px"><?php echo $datos['correo'] ?> </td>
								  <td align="center" style="padding: 10px"><?php echo $datos['fecha_rige'] ?> </td>
								</tr>
								<tr>
								  <td align="center" style="padding: 2px;font-size: 9px" width="33%">NRO. IDENTIFICACION</td>
								  <td align="center" style="padding: 2px;font-size: 9px" width="33%">CORREO ELECTRONICO</td>
								  <td align="center" style="padding: 2px;font-size: 9px" width="33%">RIGE A PARTIR</td>
								</tr>
							  </tbody>
							</table>

						  
					  </td>
				    </tr>
					
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > 
				     	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td style="padding:4px">EXPLICACIÓN: (Opcional: adjuntar Anexo)</td>
 								</tr>
								<tr>
								  <td style="padding: 5px"><?php echo $datos['novedad'] ?></td>
 								</tr>
							  </tbody>
							</table>

						  
					  </td>
				    </tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > 
				     	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td style="padding:4px">MOTIVO DE LA ACCION DE PERSONAL</td>
 								</tr>
								<tr>
								  <td style="padding: 4px"><b><?php echo $datos['motivo'] ?></b></td>
 								</tr>
								  <tr>
								  <td style="padding:4px">Otros: <?php echo $datos['otro'] ?></td>
 								</tr>
							  </tbody>
							</table>

						  
					  </td>
				    </tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > 
				     	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td style="padding:4px">BASE LEGAL</td>
 								</tr>
								<tr>
								  <td style="padding: 4px"><?php echo $datos['baselegal'] ?></td>
 								</tr>
							  </tbody>
							</table>

						  
					  </td>
				    </tr>
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > 
				     	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td style="padding:4px">REFERENCIA</td>
 								</tr>
								<tr>
								  <td style="padding: 4px"><b><?php echo $datos['referencia'] ?></b></td>
 								</tr>
							  </tbody>
							</table>

						  
					  </td>
				    </tr>
					<tr>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > SITUACION ACTUAL</td>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" >SITUACION PROPUESTA</td>
				    </tr>
					
					<tr>
					  <td width="50%" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 10px;" >
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 2px">
							  <tbody>
								<tr>
								  <td width="30%" style="padding: 2px">Regimen laboral</td>
								  <td width="70%"  style="padding: 2px"><?php echo $datos['regimen'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Programa</td>
								  <td  style="padding: 2px"><?php echo $datos['programa'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Unidad</td>
								  <td  style="padding: 2px"><?php echo $datos['unidad'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Cargo</td>
								  <td  style="padding: 2px"><?php echo $datos['cargo'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Sueldo</td>
								  <td  style="padding: 2px"><?php echo $datos['sueldo'] ?></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								</tr>
							  </tbody>
							</table>

					  </td>
					  <td  width="50%" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 10px;" >
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 5px">
							  <tbody>
								<tr>
								  <td width="30%" style="padding: 2px">Regimen laboral</td>
								  <td width="70%"  style="padding: 2px"><?php echo $datos['p_regimen'] ?></td>
								</tr>
								<tr>
								  <td  style="padding:2px">Programa</td>
								  <td  style="padding: 2px"><?php echo $datos['p_programa'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Unidad</td>
								  <td  style="padding: 2px"><?php echo $datos['p_unidad'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Cargo</td>
								  <td  style="padding: 2px"><?php echo $datos['p_cargo'] ?></td>
								</tr>
								<tr>
								  <td  style="padding: 2px">Sueldo</td>
								  <td  style="padding: 2px"><?php echo $datos['p_sueldo'] ?></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								</tr>
							  </tbody>
							</table>	
						
						</td>
					</tr>
					 
					<tr>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 10px;" > ACTA FINAL
				      <br>FECHA:<?php echo $datos['ffinalizacion'] ?>
					 </td>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 10px;" >DIRECCIÓN DE TALENTO HUMANO  
				     <br><?php $info= $gestion->datos_cargos(17); echo $info['d1']; echo "<br>";echo $info['d2']; ?><br> 
				     <?php  ?>
				 </td>
				  </tr>
					
					<tr>
					  <td colspan="2" align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > <p>&nbsp;</p>
				      <p>DIOS, PATRIA Y LIBERTAD<br><p>&nbsp;</p><p>&nbsp;</p> <?php $info= $gestion->datos_cargos(10); 
				      echo $info['d1'];echo "<br>"; echo $info['d2'];  ?><br></p></td>
				  </tr>
					
					<tr>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" > <p>ADMINISTRACIÓN DEL TALENTO HUMANO</p> <p>&nbsp;</p><p>&nbsp;</p> 
				      <p><?php $info= $gestion->datos_cargos(0); ?><br><?php echo $info['elaborado']; echo "<br>"; echo $info['unidad']; ?> </p> </td>
					  <td align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;font-size: 11px;" ><p>SERVIDOR BOMBERIL </p><p>&nbsp;</p><p>&nbsp;</p> 
				     <p><?php  echo $datos['razon'];echo "<br>"; echo"C.I" .$datos['idprov'];?> <br>  </p></td>
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
