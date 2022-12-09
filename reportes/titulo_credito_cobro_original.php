<?php 
session_start();  
ob_start(); 
require '../kconfig/convertir.php';
require 'ktitulo.php';   /*Incluimos el fichero de la clase Db*/
 	
$id_ingreso		= $_GET['codigo'];

$g  			= new ReportePdf;

 $cliente 		= $g->_ciu($_GET["id"]);
 
 
$titulos 		= $g->_titulos_pagos(  $_GET["id"], $_GET["codigo"]);
	


?> 
<!doctype html>
<html>
<head>
	
<meta charset="utf-8">

 
</head>

<style type="text/css">

	@page { size: A4; margin: 0; }
	
 
	* { box-sizing: border-box; -moz-box-sizing: border-box; } 
	
	.page { 
		width: 21cm; 
		min-height: 15.7cm; 
		padding-right: 0.8cm; 
		padding-left: 1.3cm;
		padding-bottom:  0.8cm;
		padding-top:  0.8cm;	
		font-size: 15px;
		/*margin: 1cm auto; */
		} 
	
	.Mensaje{
	font-size: 11px;
 	color:#000000
  	}	
	
	.Mensajep{
	font-size: 14px;
 	color:#000000
  	}	
	
	.titulo{
	padding-left: 5px;
	padding-bottom: 2px;
	font-size: 12px;
  	}
 
	.titulo1{
	padding-left: 7px;
	padding-top: 3px;
	padding-bottom: 3px;
	font-size: 11px;
  	}
   
 </style>
	
	
<body>
 

	<?php
		while ($row=$g->_recorre( $titulos)){
			
			$concepto = trim($row['detalle']);
 	 
			
			$pago     = $g->_usuario_pago(trim($row['sesion_pago']) );
			
			$row['sesion_pago'] = $pago;
 			
		//	$detalle = $g->_variables_adicionales($concepto,$row['id_tramite']);
			
		    $detalle =  $concepto ;
	
	?>
	
	<div class="page" align="center">

				<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
				<tr>
				  <td>&nbsp;</td>
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
				<tr>
				  <td>&nbsp;</td>
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
				<tr> <td><img src="../kimages/cas.png" width="5" height="30" alt=""/></td>
				</tr>
				<tr>
				  <td>
					  
						<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
						<tr>
						  <td width="20%"></td>
						  <td colspan="2"><?php echo $cliente['razon'] ?></td>
						  <td width="40%">Periodo: <?php echo $row['anio'] .'-'.$row['mes'] ?></td>
						  </tr>
						<tr>
						  <td></td>
						  <td colspan="2"><b><?php echo strtoupper($row['nombre_rubro']) ?></b></td>
						  <td rowspan="4" align="left" valign="top"  class="titulo">
							<table width="100%" border="0" cellspacing="2" cellpadding="2">
										  <tbody>
											<tr>
											  <td>Detalle</td>
											  <td>Monto</td>
											</tr>
											 	<?php	
													    $totalCosto = 0;
														$monto_iva  = 0;
														$tarifa_cero = 0;
														$baseiva = 0;
			
													$codigo = $row['id_ren_movimiento'];
												    $stmt3  = $g->_detalle_rubros($codigo);
			
 												   	while ($xx=$g->_recorre( $stmt3)){
														$cadena = trim($xx['servicio']);
														echo '<tr>'.' <td> '.$cadena.'</td>';
														echo ' <td  align="center">'.number_format($xx['total'],2,',','.').'</td>';
														echo '</tr>'; 
														$totalCosto 	+= $xx['total'];
														$monto_iva  	+= $xx['monto_iva'];
														$tarifa_cero  	+= $xx['tarifa_cero'];
														$baseiva 		+= $xx['baseiva'];
													$i++;
											   }
											   ?> 
										  </tbody>
										</table>
							
							</td>
						  </tr>
						<tr>
						  <td></td>
						  <td width="35%"><?php echo $cliente['direccion'] ?></td>
						  <td width="5%">&nbsp;</td>
						  </tr>
						<tr>
						  <td></td>
						  <td><?php echo $cliente['idprov'] ?></td>
						  <td align="right">&nbsp;</td>
						  </tr>
						<tr>
						  <td></td>
						  <td><?php echo number_format($totalCosto,2,',','.')  ?></td>
						  <td align="right">&nbsp;</td>
						  </tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>0</td>
						  <td></td>
						  <td style="font-size: 12px">Emision: <?php echo $row['id_ren_movimiento'] ?></td> 
						  </tr>
						<tr>
						  <td>&nbsp; </td>
						  <td><?php echo number_format($totalCosto,2,',','.')  ?></td>
						  <td></td>
						  <td style="font-size: 12px">Usuario: <?php echo $row['sesion_pago'] ?></td>
						  </tr>
						<tr>
						  <td>&nbsp; </td>
						  <td><?php  echo convertir($totalCosto);  ?></td>
						  <td></td>
						  <td style="font-size: 12px">Impresion: <?php echo date('Y-m-d') ?></td>
						  </tr>
						<tr>
						  <td>&nbsp;</td>
						  <td><?php echo $row['fecha'] ?></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						</tr>
						<tr>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  </tr>
						<tr>
						  <td>&nbsp; </td>
						  <td colspan="3"><?php echo $detalle ?></td>
						  </tr>
						</tbody>
					</table>

					</td>
				</tr>

				</tbody>
			</table>

				  
			    
 	</div>		

	<?php
	  	}
	?>	
	
</body>
</html>
<?php 
	/*
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
 */
 
?>