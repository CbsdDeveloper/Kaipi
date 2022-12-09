<?php 
session_start( );  
 
 

ob_start(); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		 
$id 		= 	$_GET['id'];
  
 
$gestion->QR_DocumentoDoc($id);

?>
<!DOCTYPE html>
<html>
	
<head lang="en">

<meta charset="UTF-8">

	 <link rel="stylesheet" href="impresion.css" />
	 
</head>		

<body>
	
	<table width="95%">
					  <tr>
					    <td width="11%" align="left" valign="top" style="font-size: 11px">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
						</td>
						<td colspan="3" align="left" style="font-size: 11px">
							<?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?>
						</td>
							 <td width="6%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
		  </table>
 
  
	<table>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px">REPORTE DE CONTROL *** TRANSFERENCIAS SPI-SP ***</td> </tr>
 
</table>
	<p></p>
 <?php   
 	$datos = $gestion->GrillaSPI($id); 
 ?>
	<table>
					<tr>
					  <td class="solid" width="25%" style="font-size: 10px">INSTITUCION</td>
					  <td class="solid" width="75%" style="font-size: 10px"><?php echo $datos['empresa']  ?></td>
				    </tr>
					<tr>
					  <td class="solid" style="font-size: 10px">FECHA REPORTE </td>
					  <td class="solid" style="font-size: 10px"><?php echo  $datos['fecha']; ?></td>
	  </tr>
					<tr>
					  <td class="solid" style="font-size: 10px">FECHA AFECTACION</td>
					  <td class="solid" style="font-size: 10px"><?php echo  $datos['fecha_envio']; ?></td>
				    </tr>
	 </table>
	<p></p>
	<table>
					<tr>
					  <td class="solid" width="25%" style="font-size: 10px">NUMERO CONTROL</td>
					  <td class="solid" width="75%" style="font-size: 10px"><?php echo $datos['control']  ?></td>
				    </tr>
					<tr>
					  <td class="solid" style="font-size: 10px">MONTO TOTAL   </td>
					  <td class="solid" style="font-size: 10px"><?php echo  $datos['total']; ?></td>
	  </tr>
					<tr>
					  <td class="solid" style="font-size: 10px"><span class="solid" style="font-size: 10px">NUMERO REGISTROS </span></td>
					  <td class="solid" style="font-size: 10px"><span class="solid" style="font-size: 10px"><?php echo  $datos['registros']; ?></span></td>
	  </tr>
					<tr>
					  <td   style="font-size: 10px">&nbsp;</td>
					  <td  style="font-size: 10px">&nbsp;</td>
	  </tr>
					<tr>
					  <td class="solid" style="font-size: 10px">CUENTA BCE</td>
					  <td class="solid" style="font-size: 10px"><span class="solid" style="font-size: 10px"><?php echo  $datos['cuenta_bce']; ?></span></td>
	  </tr>
					<tr>
					  <td class="solid" style="font-size: 10px">LOCALIDAD</td>
					  <td class="solid" style="font-size: 10px"><span class="solid" style="font-size: 10px"><?php echo  $datos['localidad']; ?></span></td>
				    </tr>
	 </table>
  <?php   
 	 $gestion->GrillaSPIBancosDetalle($id); 
 ?>
	
 <p></p>
<p></p>
 
<table>
					<tr>
					  <td class="solid"   style="padding-bottom: 30px">&nbsp;</td>
					  <td class="solid"  style="padding-bottom: 30px">&nbsp;</td>
				    </tr>
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 9px" align="center" valign="middle"><span class="solid" style="font-size: 10px"><?php echo  $datos['responsable2']; ?></span></td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 9px" align="center" valign="middle"><span class="solid" style="font-size: 10px"><?php echo  $datos['responsable1']; ?></span></td>
  </tr>
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 9px" align="center" valign="middle"><span class="solid" style="font-size: 10px"><?php echo  $datos['cargo2']; ?></span></td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 9px" align="center" valign="middle"><span class="solid" style="font-size: 10px"><?php echo  $datos['cargo1']; ?></span></td>
				    </tr>
				</table>
<p></p>
 <p></p>	
<p>&nbsp;</p>	
<p>&nbsp;</p>		
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
</body>
</html>
<?php 
 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait');  

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); 

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador

  
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 
 
?>
