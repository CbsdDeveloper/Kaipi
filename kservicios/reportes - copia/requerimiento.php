<?php 
session_start();  

ob_start(); 

 
 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
     
    <title>FORMULARIO DE SEGUIMIENTO</title>
	
    <?php  
	
			require('../view/Head.php') ;
 
 
 			require('kreportes.php'); 
			$gestion   		= 	new ReportePdf; 		 
			$idasiento 		=   $_GET['id'];
			$datos 			=	$gestion->Tramite_req($idasiento);
			$gestion->QR_DocumentoDoc($idasiento);
?>
 
	 
 	 		 
</head>
	
<body>

 
		 
     <div class="col-md-12"> 
		
		   <table width="100%">
							  <tr>
								<td width="15%" align="left" valign="top" style="font-size: 11px">
									<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
								</td>
								<td  width="80%" colspan="3" align="left" style="font-size: 11px">
									<?php 
										echo $gestion->EmpresaCab().'<br>';
										echo $gestion->_Cab( 'ruc_registro' ).'<br>';
										echo $gestion->_Cab( 'direccion' ).'<br>';
										echo $gestion->_Cab( 'telefono' ).'<br>';
										echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
									?>
									</td>
									 <td width="5%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
								</tr>
				  </table>	
 	</div>   
	
     <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	

	
 			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="4" align="center" style="font-size: 10px">&nbsp;  </td> 
				 </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 14px"><b><?php echo $datos['servicio']?></b></td> </tr>
				<tr>
				  <td colspan="4" align="center" style="font-size: 12px;color:#727272"><b>Nro.Tramite <?php echo $datos['id_ren_tramite'] ?></b></td>
  				</tr>
				<tr>
				  <td colspan="4"  style="font-size: 10px">&nbsp;</td>
 				 </tr>
				<tr>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;" width="20%">Fecha</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"  ><?php echo $datos['fecha_inicio'] ?></td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;" width="20%">Cod.CIU</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;" width="30%"><?php echo $datos['id_par_ciu'] ?></td>
    			</tr>
				<tr >
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Contribuyente</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo $datos['razon'] ?></td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Identificacion</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Elaborador por</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo $datos['login'] ?></td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Estado</td>
				  <td style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td  colspan="2"  style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Detalle</td>
				  <td  colspan="2"  style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;">Resolucion</td>
    </tr>
				<tr > 
					<td   colspan="2"  style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo trim($datos['detalle'])  ?></td>
				    <td   colspan="2"  style="font-size: 11px;padding:3px;border-collapse: collapse; border: 1px solid #AAAAAA;"><?php echo trim($datos['resolucion'])  ?></td>
			    </tr>
			
 </table>
		
	 </div>   	
	
	 <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	
	
 				 
					<?php $gestion->Tramite_variables($idasiento, $datos['id_rubro']);  ?>
				
     </div> 	

      <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px;padding-left: 18px"> 	
	
 					<?php 

					$datos= $gestion->Tramite_seg($idasiento); 

					?>
					
						<table style="border-collapse: collapse; border: 1px solid #AAAAAA;" border="0" width="100%" cellspacing="0" cellpadding="0">
						
							<tr>
								<td style="padding:3px"><?php echo $datos['fecha_seg'].'- '.$datos['novedad_seg']; ?>
 								</td>
							</tr>
							<tr>
								<td style="padding:3px">
									<?php echo $datos['accion_seg']; ?>
								</td>
									
							</tr>
							<tr>
							    <td style="padding: 3px">
									<?php echo $datos['responsable_seg']; ?>	
								</td>
								 
							</tr>
							
					</table>
    
    </div> 	   
	   
	
	 <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"> 	
		
		<table width="100%">
				 
 					<tr>
							  <td  style="font-size: 10px;padding-bottom:10px;padding-top: 40px; border-collapse: collapse; border: 1px solid #AAAAAA;" align="center" valign="middle">FIRMA DEL INSPECTOR<br> NOMBRE:<br>
							  CC.:</td>
							  <td  style="font-size: 10px;padding-bottom:10px;padding-top: 40px;;border-collapse: collapse; border: 1px solid #AAAAAA;"  align="center" valign="middle">FIRMA DEL SOLICITANTE<br> NOMBRE:<br>
							  CC.:</td>
					</tr>
					<tr>
		  					<td  style="font-size: 10px;padding-bottom:10px;padding-top: 40px;;border-collapse: collapse; border: 1px solid #AAAAAA;"  align="center" valign="middle">VISTO BUENO<br><br>
		   					 APROBADO <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/>&nbsp;&nbsp; NEGADO  <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/></td>
					 		 <td  style="font-size: 10px;padding-bottom:10px;padding-top: 40px;;border-collapse: collapse; border: 1px solid #AAAAAA;"  align="center" valign="middle">TCRNL. HUGO ASTUDILLO TORRES<br><br>JEFE DE CBVS</td>
	  				</tr>
				</table>
		
	  </div> 		
	
	
	<p>&nbsp;</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
		
 </body>
</html>
<?php 
 
 /*
set_time_limit(0);
ini_set("memory_limit",-1);
ini_set('max_execution_time', 0);
	
	
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape
	
	
$html = ob_get_contents();	

     $dompdf->load_html($html);

	
 	ob_get_clean();	

	 $dompdf->render(); // Generar el PDF desde contenido HTML
 
 	$canvas = $dompdf->getCanvas(); 
 
	$w = $canvas->get_width(); 
	$h = $canvas->get_height(); 

	$imageURL = 'fondo_agua_logo.png'; 
	$imgWidth = 300; 
	$imgHeight = 200; 

	$canvas->set_opacity(.8); 

	$x = (($w-$imgWidth)/2); 
	$y = (($h-$imgHeight)/2); 

	$canvas->image($imageURL, $x, $y, $imgWidth, $imgHeight); 
	
 
 

	$pdf = $dompdf->output(); // Obtener el PDF generado

	 //$dompdf->stream(); // Enviar el PDF generado al navegador

	$registro = trim($_SESSION['ruc_registro']);

	$filename = "AccionPersonal".$registro.".pdf";



	$dompdf->stream($filename, array("Attachment" => false));
	
 */
 
 
?>
