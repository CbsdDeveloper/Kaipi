<?php
session_start();
ob_start();
require('kreportes.php');
$gestion   		= 	new ReportePdf;
$id 		    = trim($_GET['codigo']);

$datos 			= $gestion->ficha_combustible($id);

?>
<!DOCTYPE html>
<html>

<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="css/style.css" rel="stylesheet">

</head>

<body>
 

	<div id="content">
 
		
		    	<table width="100%"  border="0" style="border-collapse: collapse;">
					 
					  <tr>
					    <td align="left" style="border: 1px solid #AAAAAA;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="10%"><img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" align="absmiddle"  width="100" height="80"></td>
								  <td width="90%" style="font-size: 10px;padding: 5px"><?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?></td>
								</tr>
							  </tbody>
							</table>

						</td>
						<td width="50%"  style="border: 1px solid #AAAAAA;" align="center" valign="top"><span style="font-size: 20px;color: #0E0DF7;font-weight:bold">ORDEN DE ABASTECIMIENTO</span><br>
						  <span style="font-size:15px;color: #0E0DF7;font-weight:bold ">  <?php echo  $datos['referencia'] ?></span>
					</td>
						</tr>
  			<tr>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
	      </tr>
		  </table>
		  
  
			   <?php   $gestion->pie_rol('AD-CO',$datos,1) ?>
			    
			 
		
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tbody>
					<tr>
					  <td style="padding: 50px">&nbsp;</td>
					  <td style="padding: 50px">&nbsp;</td>
					</tr>
				  </tbody>
				</table>

 				<table width="100%"  border="0" style="border-collapse: collapse;">
					 
					  <tr>
					    <td align="left" style="border: 1px solid #AAAAAA;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="10%"><img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" align="absmiddle"  width="100" height="80"></td>
								  <td width="90%" style="font-size: 10px;padding: 5px"><?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?></td>
								</tr>
							  </tbody>
							</table>

						</td>
						<td width="50%"  style="border: 1px solid #AAAAAA;" align="center" valign="top"><span style="font-size: 20px;color: #0E0DF7;font-weight:bold">ORDEN DE ABASTECIMIENTO</span><br>
						  <span style="font-size:15px;color: #0E0DF7;font-weight:bold ">  <?php echo  $datos['referencia'] ?></span>
					</td>
						</tr>
  			<tr>
					    <td align="left">&nbsp;</td>
					    <td align="left">&nbsp;</td>
	      </tr>
		  </table>
	  
                  <?php   $gestion->pie_rol('AD-CO',$datos,2) ?>
			  
 
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

 
$registro = trim($_SESSION['ruc_registro']);

$filename = "DocMemo" . $registro . ".pdf";
 
$dompdf->stream($filename, array("Attachment" => false));
 

?>