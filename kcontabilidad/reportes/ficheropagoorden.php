<?php 
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 

$idasiento 		= $_GET['a'];

$datos 			=	$gestion->CabAsientoOrden($idasiento);


 $gestion->QR_DocumentoDoc($idasiento);


$forma_detalle = ' Forma de pago '.$datos['tipo'].' Nro.Documento '.$datos['cheque'] ;
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
	 
	<div class="col-md-12" style="padding: 7px">
         <table width="95%">
					  <tr>
					    <td width="20%" align="left" valign="top" style="font-size: 11px">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="122" height="96">
						</td>
						<td  width="80%" align="left" style="font-size: 11px">
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
				 
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"><b>ORDEN DE  PAGO</b>  </td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 10px"><?php echo 'OP-'.$datos['op'].' - '.$datos['anio'] ?></td> </tr>
				<tr>
				  <td rowspan="3" style="font-size: 11px">Para :</td>
				  <td colspan="3" style="font-size: 10px">&nbsp;</td>
  </tr>
				<tr>
				  <td colspan="3" style="font-size: 12px"><?php echo $datos['t10'] ?><br><?php echo $datos['t11'] ?></td>
  </tr>
				 
				<tr>
				  <td colspan="4"  style="font-size: 9px">&nbsp;</td>
  </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 9px">Nro <?php echo $datos['comprobante'] ?></td></tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Fecha orden</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['forden'] ?></td>
				  <td class="solid" style="font-size: 9px" width="20%"></td>
				  <td class="solid"   style="font-size: 9px" width="30%"></td>
    			</tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Fecha Transaccion</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['fecha'] ?></td>
				  <td class="solid" style="font-size: 9px" width="20%">Nro.Asiento</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['id_asiento'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Solicita</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['proveedor'] ?></td>
				  <td class="solid"  style="font-size: 9px">Identificacion</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>  
				  <td class="solid"   style="font-size: 9px">Nro.Certificacion</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['id_tramite'] ?></td>
				  <td class="solid"   style="font-size: 9px">Nro.Documento</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['documento'] ?></td>
  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Elaborador por</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['sesion'] ?></td>
				  <td class="solid"   style="font-size: 9px">Estado</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td class="solid"  colspan="4" style="font-size: 9px">Detalle</td>
    </tr>
				<tr > <td  class="solid"   colspan="4" style="font-size: 9px"><?php echo trim($datos['detalle']).$forma_detalle  ?></td> </tr>
			
 </table>
	<p></p>
	<table>
 			    <tr bgcolor=#ECECEC>
 			      <td colspan="2" align="left" style="font-size: 10px">Solicito realizar el pago bajo los datos estipulados a continuacion</td> </tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Fecha</td>
				  <td class="solid"   style="font-size: 9px" width="80%"><?php echo $datos['fecha'] ?></td>
			    </tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Beneficiario</td>
				  <td class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['proveedor'] ?></span></td>
			  </tr>
				<tr>  
				  <td class="solid"   style="font-size: 9px">Nro.Identificacion</td>
				  <td class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['idprov'] ?></span></td>
	  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Banco Beneficiario</td>
				  <td class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['banco'] ?></span></td>
	  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Tipo Cuenta</td>
				  <td class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['tipo_cuenta'] ?></span></td>
	  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Nro.Cuenta</td>
				  <td class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['cuenta'] ?></span></td>
	  </tr>
 </table>
<p></p>
	<table>
 			    <tr bgcolor=#ECECEC><td colspan="6" align="left" style="font-size: 10px">Solicito realizar el pago con el monto a pagar (Deducciones de impuestos/anticipos)</td> </tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Documento</td>
				  <td class="solid"   style="font-size: 9px" width="20%"><?php echo $datos['documento'] ?></td>
				  <td class="solid" align="right"  style="font-size: 9px" width="20%" ><span class="solid" style="font-size: 9px">Nro.Factura</span></td>
				  <td class="solid"   style="font-size: 9px" width="20%"><?php echo $datos['factura'] ?></td>
				  <td class="solid" align="right"  style="font-size: 9px" width="20%">Nro.Comprobante</td>
				  <td class="solid"   style="font-size: 9px" width="20%"><?php echo $datos['retencion'] ?></td>
			    </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px"><span class="solid" style="font-size: 9px">Monto a pagar</span></td>
				  <td colspan="5" class="solid"  style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo $datos['apagar'] ?></span></td>
	  </tr>
 </table>
	
<p></p>
	<table>
 			    <tr bgcolor=#ECECEC>
 			      <td align="left" style="font-size: 10px">Aprobado y Autorizado por :</td> </tr>
				<tr>
				  <td  style="font-size: 9px"><p>&nbsp;</p>
			      <p>&nbsp;</p>
			      <p>&nbsp;</p></td>
			    </tr>
				<tr>
				  <td align="left"> 
					   <?php  $gestion->pie_rol('CO-OG'); ?>
					
					</td>
	  </tr>
				 
 </table>
<p></p>
<p>&nbsp;</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
 
 	 
</body>
</html>
<?php 




 /*

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador


 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 */
?>
