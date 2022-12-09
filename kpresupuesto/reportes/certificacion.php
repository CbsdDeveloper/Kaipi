<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	 new ReportePdf; 		
$id 		    =    trim($_GET['codigo']);
$datos 		    =    $gestion->Memorando($id);

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
	   <table width="100%" border="0" class="cabecera_font">
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
	<img width="80" height="80" src='logo_qr.png'/><br>			
	<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
</div>
	
<div id="content">
  			    <table width="100%">
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px"> 
					  <b>   CERTIFICACION NRO. <?php   	echo trim($datos['comprobante']) ?> </b>
				 </td>
				</tr>
				 <tr>
				  <td  align="right" style="font-weight: normal;font-size: 10px"> 
					  Nro Tramite: <?php  echo $id ?>  
				 </td>
				</tr>
			   </table>  
 	           
		        <table width="100%" border="0">
				  <tbody>
					<tr>
					  <td width="10%">Fecha</td>
					  <td width="90%"><?php  echo $datos['fcertifica'] ?> </td>
				    </tr>
					<tr>
					  <td>Asunto</td>
					  <td><?php  echo $datos['detalle'] ?> </td>
					</tr>
					<tr>
					  <td>Memorando</td>
					  <td><?php  echo $datos['documento'] ?></td>
				    </tr>
					<tr>
					  <td>Solicita</td>
					  <td><?php  echo $datos['user_sol'] ?></td>
				    </tr>
					<tr>
					  <td>Unidad</td>
					  <td><?php  echo $datos['unidad'] ?></td>
					</tr>
					<tr>
					  <td colspan="2" align="justify">&nbsp;</td>
				    </tr>
					<tr>
					  <td colspan="2" align="justify">
					  De conformidad con lo expresado en el Art.115 del Código de Planificación y Finanzas Públicas y una vez revisado el presupuesto aprobado para el ejercicio fiscal, certifico que existe disponibilidad presupuestaria en la(s) partida(s) presupuestaria detallada en la descripcion referida, previo a iniciar el proceso de contratación correspondientes:	
					</td>
			    </tr>
				  </tbody>
				</table>
				<br>
		 		<?php      $gestion->GrillaCertificacion($id); ?>
		  		<table width="100%" border="0">
				  <tbody>
					<tr>
					  <td>El monto de la presente certificacion presupuestaria asciende a $ <?php  echo $gestion->_total() ?> Dólares americanos</td>
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="justify">Adicionalmente, su vigencia para el inicio del o los procesos de contratación serán de 30 dias, a apartir de su fecha de emisión.</td>
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
 
				<?php      $gestion->firma_reportes('PR-CE'); ?>
 
	
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
