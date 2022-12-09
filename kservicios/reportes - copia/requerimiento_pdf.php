<?php 
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$idasiento 		=   $_GET['id'];
$datos 			=	$gestion->Tramite_req($idasiento);
$gestion->QR_DocumentoDoc($idasiento);
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
  </div> 
  
<table>
	

				 
<tr><td colspan="4" align="center" style="font-size: 10px">&nbsp;  </td> </tr>
			    <tr bgcolor=#ECECEC><td colspan="4" align="center" style="font-size: 12px"><?php echo $datos['servicio']?></td> </tr>
				<tr>
				  <td colspan="4" align="center" style="font-size: 10px;color:#727272">Nro.Tramite<?php echo $datos['id_ren_tramite'] ?></td>
  				</tr>
				<tr>
				  <td colspan="4"  style="font-size: 10px">&nbsp;</td>
 				 </tr>
				<tr>
				  <td  class="solid"  style="font-size: 9px" width="20%">Fecha</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['fecha_inicio'] ?></td>
				  <td class="solid" style="font-size: 9px" width="20%">Cod.CIU</td>
				  <td class="solid"   style="font-size: 9px" width="30%"><?php echo $datos['id_par_ciu'] ?></td>
    			</tr>
				<tr >
				  <td class="solid"    style="font-size: 9px">Contribuyente</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['razon'] ?></td>
				  <td class="solid"  style="font-size: 9px">Identificacion</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['idprov'] ?></td>
  			  </tr>
				<tr>
				  <td class="solid"   style="font-size: 9px">Elaborador por</td>
				  <td class="solid"  style="font-size: 9px"><?php echo $datos['login'] ?></td>
				  <td class="solid"   style="font-size: 9px">Estado</td>
				  <td class="solid"   style="font-size: 9px"><?php echo $datos['estado'] ?></td>
    </tr>
				<tr >
				  <td  colspan="2" class="solid" style="font-size: 9px">Detalle</td>
				  <td  colspan="2" class="solid" style="font-size: 9px">Resolucion</td>
    </tr>
				<tr > <td   colspan="2"  class="solid" style="font-size: 9px"><?php echo trim($datos['detalle'])  ?></td>
				  <td   colspan="2"  class="solid" style="font-size: 9px"><span class="solid" style="font-size: 9px"><?php echo trim($datos['resolucion'])  ?></span></td>
			    </tr>
			
 </table>
 
	<?php $gestion->Tramite_variables($idasiento, $datos['id_rubro']);  ?>
 
<p>&nbsp;</p>	
	
	<table>
					<tr>
					  <td class="solid"   style="padding-bottom: 20px">&nbsp;</td>
					  <td class="solid"  style="padding-bottom: 20px">&nbsp;</td>
					</tr>
					
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">FIRMA DEL INSPECTOR<br> NOMBRE:<br>
					  CC.:</td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">FIRMA DEL SOLICITANTE<br> NOMBRE:<br>
					  CC.:</td>
					</tr>
		<tr>
		  <td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">VISTO BUENO<br><br>
		    APROBADO <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/>&nbsp;&nbsp; NEGADO  <img src="../../kimages/chequea.png" align="absmiddle"  width="10" height="10"/></td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 35px;font-size: 8px" align="center" valign="middle">TCRNL. HUGO ASTUDILLO TORRES<br><br>JEFE DE CBVS</td>
	  </tr>
				</table>
 
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
