<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['codigo']);
 
$datos 		= $gestion->Memorando($id);
 
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link href="css/style.css" rel="stylesheet">
	
<style>
    @page { margin: 180px 50px; }
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 120px; background-color:#FFFFFF; text-align: center; }
	
    #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 50px; background-color:#FFFFFF; }
	
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
	 margin: 3px;	
	 padding: 3px;
  	}
	
	.tablap {
 	 border: #767676 1px solid;
	 margin: 3px;	
	 padding: 3px;
	 border-collapse: collapse;
  	}
	
 
	.lado {
 	 border: #767676 1px solid;
	 margin: 1px;	
	 padding: 1px;
	 border-collapse: collapse;
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
	
<div id="header" style="width: 100%">
   <div class="round3" style="padding: 7px">
         <table width="95%">
					 <tr>
					 <td width="85%" align="left" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td>
					  <td width="10%" rowspan="5" align="right" valign="top">  <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="70"></td>
					</tr>
					<tr>
					  <td align="left" style="font-size: 10px">RUC <?php echo $gestion->_Cab( 'ruc_registro' ); ?></td>
					  </tr>
					<tr>
					   <td align="left" style="font-size: 10px">Direccion <?php echo $gestion->_Cab( 'direccion' ); ?></td>
					  </tr>
					<tr>
					   <td  align="left" style="font-size: 10px">Telefono <?php echo $gestion->_Cab( 'telefono' ); ?></td>
					  </tr>
					<tr>
					 <td  align="left" style="font-size: 10px"><?php echo $gestion->_Cab( 'ciudad' ); ?> - Ecuador</td>
					  </tr>
				 </table>
  </div> 
 </div>
 
<div id="footer" style="width: 90%">
	<img width="80" height="80" src='logo_qr.png'/><br>			
	<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
</div>
	
<div id="content" style="width: 100%">
 	 
	  <div style="padding: 7px">  
 			  <table width="100%">
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px"> 
					  <b>   COMPROMISO NRO. <?php   	echo trim($datos['comprobante']) ?> </b>
				 </td>
				</tr>
				 <tr>
				  <td  align="right" style="font-weight: normal;font-size: 10px"> 
					  <b>   Fecha: <?php  echo $datos['fcompromiso'] .' Nro.Tramite  '. $id ?> </b>
				 </td>
				</tr>
			   </table>  
 	           
		        <table width="100%" border="0">
				  <tbody>
					<tr>
					  <td width="10%">&nbsp;</td>
					  <td width="90%">&nbsp;</td>
				    </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				    </tr>
					<tr>
					  <td align="left" valign="top">Detalle</td>
					  <td><?php  echo $datos['detalle'] ?> </td>
					</tr>
					<tr>
					  <td align="left" valign="top">Documento</td>
					  <td><?php  echo $datos['cur'] ?></td>
				    </tr>
					<tr>
					  <td align="left" valign="top">Solicita</td>
					  <td><?php  echo $datos['user_sol'] ?></td>
				    </tr>
					<tr>
					  <td align="left" valign="top">Unidad</td>
					  <td><?php  echo $datos['unidad'] ?></td>
				    </tr>
					<tr>
					  <td align="left" valign="top">Referencia</td>
					  <td><?php  echo $datos['documento'] ?></td>
					</tr>
					<tr>
					  <td colspan="2" align="justify">&nbsp;</td>
				    </tr>
					<tr>
					  <td colspan="2" align="justify">
					  De conformidad con lo expresado en el Art.115 del Código de Planificación y Finanzas Públicas y una vez revisado el presupuesto aprobado para el ejercicio fiscal, certificado y que existe disponibilidad presupuestaria en la(s) partida(s) presupuestaria detallada en la descripcion referida, se realiza el compromiso presupuestario con el siguiente detalle:	
					</td>
			    </tr>
				  </tbody>
				</table>
				<h6>&nbsp;  </h6>
		 		 <?php      $gestion->GrillaCompromiso($id); ?>
		  		<table width="100%" border="0">
				  <tbody>
					<tr>
					  <td>&nbsp;</td>
				    </tr>
					<tr> 
						<td align="justify">El monto del presente compromiso presupuestario asciende a $ <?php  echo $gestion->_total() ?> Dólares americanos, que corresponde a <b><?php  echo trim($datos['razon'])?></b>, con Nro.Identificacion <?php  echo $datos['idprov']?>.</td>
						
					
					</tr>
					<tr>
					  <td align="justify"></td>
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

		  
		      <?php      $gestion->firma_reportes('PR-CO'); ?>
		  
  
		  
 	 </div>
	
 	  <p style="padding: 1px">&nbsp; </p>
	
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
 
//$filename = "Anexo".time().'.pdf';
$filename = "nota".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>
