<?php 
session_start( );  
ob_start(); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		 

$idasiento 		= $_GET['a'];

$datos 			=	$gestion->CabAsiento($idasiento);

$gestion->QR_DocumentoDoc($idasiento);


/*

COMPROBANTE DIARIO CONTABLE

*/
?>
<!DOCTYPE html>
<html>
	
<head lang="en">
	
<meta charset="UTF-8">
 
	 <link rel="stylesheet" href="impresion.css" />
	
	 
</head>		
	
<body>
	
   <div  style="padding: 2px">
	   
	   <table width="100%" border="0" class="cabecera_font">
		  <tbody>
			<tr>
			  <td width="20%" valign="top"><img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
				
			  <td width="80%" valign="top"><?php echo $gestion->Empresa(); ?><br><br><?php echo $gestion->_Cab( 'ruc_registro' ); ?><br>
				  
				  <?php echo $gestion->_Cab( 'direccion' ); ?><br><?php echo $gestion->_Cab( 'telefono' ); ?><br>Modulo Contabilidad<br>
				  COMPROBANTE DE DIARIO <?php echo $datos['tipo_asiento_imprime'] ?>
				  
			 </td>
				
			</tr>
			  
		  </tbody>
		</table>
   </div> 
	
<table>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"> </td> </tr>
			    <tr bgcolor=#ECECEC>
			      <td colspan="4" align="center" style="font-size: 10px"></td> </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 12px">Nro Comprobante Diario <b> <?php echo $datos['comprobante'] ?></b></td></tr>
				<tr>
				  <td class="solid"  style="font-size: 9px" width="20%">Fecha</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['fecha'] ?></td>
				  <td class="solid" style="font-size: 9px" width="20%">Nro.Asiento</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['id_asiento'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Beneficiario</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['proveedor'] ?></td>
				  <td class="solid"  style="font-size: 9px">Identificacion</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Elaborador por</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['elaborado'] ?></td>
				  <td class="solid"   style="font-size: 9px">Estado</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td class="solid"  colspan="4" style="font-size: 9px">Detalle</td>
    </tr>
				<tr > <td  class="solid"   colspan="4" style="font-size: 9px"><?php echo $datos['detalle'] ?></td> </tr>
			
 </table>
	<p></p>
 <?php   
 	 $gestion->GrillaAsiento($idasiento); 
 ?>
 <p></p>
 <p></p>
	 <?php   
 	 $gestion->GrillaEnlaces($idasiento);
 ?>
 <p></p>
 <p></p>
 <p></p>
 <p></p>	
	 <?php     $gestion->pie_rol('CO-RC', $datos['sesion']); ?>
 	 
<p></p>
<p></p>	
<p></p>	
<p>&nbsp;</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	

</body>
</html>
<?php 
 

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador


 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
?>
