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
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 110px; background-color:#FFFFFF; text-align: center; }
	
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
         <table width="90%">
					 <tr>
					 <td align="left" style="font-size: 11px"><?php echo $gestion->Empresa(); ?></td>
					  <td rowspan="5" align="right" valign="top">  <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="70"></td>
					</tr>
					<tr>
					  <td align="left" style="font-size: 11px">RUC <?php echo $gestion->_Cab( 'ruc_registro' ); ?></td>
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
	<?php echo $gestion->pie_cliente( $datos['nombre']); ?>
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
					  <td>Asunto</td>
					  <td><?php  echo $datos['detalle'] ?> </td>
					</tr>
					<tr>
					  <td>Memorando</td>
					  <td><?php  echo $datos['nro_memo'] ?></td>
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
					  <td align="justify">El monto del presente compromiso presupuestaria asciende a $ <?php  echo $gestion->_total() ?>				        Dólares americanos, que corresponde al  Rol de nomina generado por la Subgerencia de Talento Humano.</td>
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

		       <table width="100%"  class="tablap">
				 
				 <tr >
				   <td class="lado" with="50%"  align="center" style="font-weight: normal;font-size: 10px"><p>&nbsp;</p>
			       <p>&nbsp;</p></td>
 				   <td class="lado" with="50%"  align="center" style="font-weight: normal;font-size: 10px">&nbsp;</td>
			     </tr>
				 <tr>
				   <td class="lado" with="50%"  align="center" style="font-weight: normal;font-size: 10px"> Elaborado </td>
 				   <td class="lado" with="50%"  align="center" style="font-weight: normal;font-size: 10px">Autorizado</td>
			     </tr>
				 <tr>
				  <td colspan="2" class="lado"  align="left" style="font-weight: normal;font-size: 10px"> 
					<?php  echo   $datos['sesion'] ?>
				 </td>
			     </tr>
			   </table> 
		 
		  
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
