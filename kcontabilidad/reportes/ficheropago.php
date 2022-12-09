<?php 
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$idasiento 		=   $_GET['a'];
$datos 			=	$gestion->CabAsiento($idasiento);

$gestion->QR_DocumentoDoc($idasiento);

$forma_detalle = ' Forma de pago: '.$datos['tipo_pago'].' Nro.Documento: '.$datos['cheque'] ;

/*
$datos['cheque'] = $datosB['cheque'];  
		$datos['tipo']   = $datosB['tipo'];  
		$datos['pagado'] = $datosB['debe'] +  $datosB['haber'];  
		 
		$datos['tipoc']   = $tipo_mov;  
*/

?>
<!DOCTYPE html>
<html><head lang="en">
<meta charset="UTF-8">

 
	
	 <link rel="stylesheet" href="impresion.css" />
	
	<style>
    @page { margin: 180px 50px; }
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 110px; background-color:#FFFFFF; text-align: center; }
	
    #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 180px; background-color:#FFFFFF; }
	
    #footer .page:after { 
	/*	content: counter(page, upper-roman); */
		counter-increment: section;
        content: "Pag " counter(section) " ";
	
	}

	.round3 {
    border: 1px solid #767676;
    border-radius: 5px;
    }
	
	.tabla {
 	 border: #767676 1px solid;
	 margin: 1px;	
	 padding: 1px;
  	}
	
	.tablaTotal {
 	 margin: 3px;	
	 padding: 3px;
  	}
	
	
	.tablaPie {
 	 border: #767676 1px solid;
	 margin: 25px;	
	 padding: 25px;
  	}
	.tablaPie1 {
 	 border: #767676 1px solid;
	 margin: 3px;	
	 padding: 3px;
  	}
  </style>
	 
</head>		
<body>
	 
	<div style="padding: 7px">
         <table width="95%">
					  <tr>
					    <td width="15%" align="left" valign="top" style="font-size: 11px">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="135" height="107">
						</td>
						<td width="85%" align="left" style="font-size: 11px">
							<?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?>
							</td>
					    </tr>
		  </table>
  </div> 
  
<table>
				 
<tr><td colspan="4" align="center" style="font-size: 10px">&nbsp;  </td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 14px"><b><?php echo $datos['tipoc']?></b></td> </tr>
				<tr>
				  <td colspan="4" align="center" style="font-size: 12px;color:#727272"><b><?php echo $datos['comprobante_pago'] ?></b></td>
  				</tr>
				<tr>
				  <td colspan="4"  style="font-size: 10px">&nbsp;</td>
 				 </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 10px">  <?php echo ''; //$datos['comprobante'] ?></td></tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Fecha</td>
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
				<tr > <td  class="solid"   colspan="4" style="font-size: 9px"><?php echo trim($datos['detalle']).$forma_detalle  ?></td> </tr>
			
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
 
<p>&nbsp;</p>	
   
 	  <?php  $gestion->pie_rol('CO-PP'); ?>
 
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

$dompdf->load_html(  ob_get_clean())  ;

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador


 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
