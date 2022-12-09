<?php 
session_start();  
ob_start(); 

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
		min-height: 29.7cm; 
		padding-right: 0.8cm; 
		padding-left: 1.3cm;
		padding-bottom:  0.8cm;
		padding-top:  0.8cm;	
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
	font-size: 11px;
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
				<tr> <td>
					  
							   <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tbody>
									<tr>
									  <td><img src="logo_repo.png" width="745" height="100"/>
									  </td>
									</tr>
								  </tbody>
							  </table>
					  
			      </td>
				</tr>
				<tr>
				  <td>
					  
						<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
						<tr>
						  <td colspan="4" align="center"><b><span style="font-size: 15px"><?php echo strtoupper($row['nombre_rubro']) ?></span></b></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" ><span class="Mensajep">Periodo <?php echo $row['anio'] .'-'.$row['mes'] ?></span></td>
						  </tr>
						<tr>
						   <td  class="titulo" width="10%">Identificacion</td>
						  <td  class="titulo"  width="40%"><?php echo $cliente['idprov'] ?></td>
						  <td  class="titulo"  width="10%" align="right">Nro. Emision</td>
						  <td  class="titulo"  width="40%"><?php echo $row['id_ren_movimiento'] ?></td> 
						  </tr>
						<tr>
						  <td  class="titulo"  >Contribuyente</td>
						  <td  class="titulo"  ><?php echo $cliente['razon'] ?></td>
						  <td  class="titulo"  align="right">Nro.Comprobante</td>
						  <td   class="titulo" ><?php echo $row['documento'] ?></td>
						  </tr>
						<tr>
						  <td  class="titulo" >Dirección</td>
						  <td  class="titulo"  ><?php echo $cliente['direccion'] ?></td>
						  <td  class="titulo"  align="right">Emision</td>
						  <td   class="titulo"  ><?php echo $row['fecha'] ?></td>
						  </tr>
						<tr>
						  <td  class="titulo" >&nbsp;</td>
						  <td  class="titulo"  >&nbsp;</td>
						  <td  class="titulo"  align="right"><span class="titulo1">Usuario</span></td>
						  <td   class="titulo"  ><?php echo $row['sesion_pago'] ?></td>
						</tr>
						<tr>
						  <td  class="titulo" >&nbsp; </td>
						  <td  class="titulo"  >&nbsp;</td>
						  <td  class="titulo"  align="right"><span class="titulo1">Impresion</span></td>
						  <td   class="titulo"  ><?php echo date('Y-m-d') ?></td>
						  </tr>
						<tr>
						  <td colspan="4">
							<table width="75%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td  bgcolor="#FBFBFB" class="titulo1"> <?php echo $detalle ?></td>
								  </tr>
								</tbody>
							  </table>
						   </td>
						  </tr>

						</tbody>
					</table>

					</td>
				</tr>

				<tr>
				  <td>
					  
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td width="75%"  style="font-size: 11px;padding: 4px">

						   <table width="100%" class="titulo">
							   
							<thead> <tr> <th width="80%">Concepto </th> <th align="center" width="20%">Valor </th>    
								 </tr>
							</thead>
							<tbody>
								 
						      <tr>
							       <td colspan="1" rowspan="2" align="right">
								  
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
							       <td style="font-size: 16px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center">A pagar</td>
					          </tr>
						      <tr> 
						        <td style="font-size: 16px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center"><?php echo number_format($totalCosto,2,',','.')  ?></td>
							   </tr>
							 <tr>
							   <td colspan="1" align="right">&nbsp;</td>
							   <td align="right" class="precio" >&nbsp;</td>
							   </tr>
							   </tbody>
							</table> 
							
						 </td>
						<td width="25%" valign="top"  style="font-size: 11px;padding: 4px;color: #F50D11;font-style: italic">Emergencias  24 / 7<br>
					Valencia     - 05 2948 102<br>
					El Vergel    - 05 2329 049<br>
					ECU 911</td>
					  </tr>
					  </tbody>
				  </table>
					</td>
				</tr>
				<tr>
				  <td>
					  
					  <table width="90%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td align="center"><img src="../reportes/oscar.png" width="150"/></td>
						<td align="center"><img src="../reportes/maricela.png" width="150"/></td> 
						<td align="center"><img src="../reportes/financiero.png" width="150" height="80" /></td>
					  </tr>
					  <tr>
						<td class="titulo" align="center">Cabo. José Jiménez Troya</td>
						<td class="titulo" align="center">Ing. Maricela Navarro Guerrero </td>
						<td class="titulo" align="center">CPA. Natalia Carrazco </td>
					  </tr>
					  <tr>
						<td class="titulo" align="center">Inspector de Seguridad</td>
						<td class="titulo" align="center">Recaudadora (e)</td>
						<td class="titulo" align="center">Director Financiero (e)</td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E"><b>ORIGINAL CONTRIBUYENTE</b></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
			  </tbody>
			</table>

				<p>&nbsp;</p>

			   <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
				<tr> <td>
					  
							   <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tbody>
									<tr>
									  <td><img src="logo_repo.png" width="745" height="100"/>
									  </td>
									</tr>
								  </tbody>
							  </table>
					  
			      </td>
				</tr>
				<tr>
				  <td>
					  
						<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
						<tr>
						  <td colspan="4" align="center"><b><span style="font-size: 15px"><?php echo strtoupper($row['nombre_rubro']) ?></span></b></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" ><span class="Mensajep">Periodo <?php echo $row['anio'] .'-'.$row['mes'] ?></span></td>
						  </tr>
						<tr>
						   <td  class="titulo" width="10%">Identificacion</td>
						  <td  class="titulo"  width="40%"><?php echo $cliente['idprov'] ?></td>
						  <td  class="titulo"  width="10%" align="right">Nro. Emision</td>
						  <td  class="titulo"  width="40%"><?php echo $row['id_ren_movimiento'] ?></td> 
						  </tr>
						<tr>
						  <td  class="titulo"  >Contribuyente</td>
						  <td  class="titulo"  ><?php echo $cliente['razon'] ?></td>
						  <td  class="titulo"  align="right">Nro.Comprobante</td>
						  <td   class="titulo" ><?php echo $row['documento'] ?></td>
						  </tr>
						<tr>
						  <td  class="titulo" >Dirección</td>
						  <td  class="titulo"  ><?php echo $cliente['direccion'] ?></td>
						  <td  class="titulo"  align="right">Emision</td>
						  <td   class="titulo"  ><?php echo $row['fecha'] ?></td>
						  </tr>
						<tr>
						  <td  class="titulo" >&nbsp;</td>
						  <td  class="titulo"  >&nbsp;</td>
						  <td  class="titulo"  align="right"><span class="titulo1">Usuario</span></td>
						  <td   class="titulo"  ><?php echo $row['sesion_pago'] ?></td>
						</tr>
						<tr>
						  <td  class="titulo" >&nbsp; </td>
						  <td  class="titulo"  >&nbsp;</td>
						  <td  class="titulo"  align="right"><span class="titulo1">Impresion</span></td>
						  <td   class="titulo"  ><?php echo date('Y-m-d') ?></td>
						  </tr>
						<tr>
						  <td colspan="4">
							<table width="75%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td  bgcolor="#FBFBFB" class="titulo1"><?php echo $detalle ?></td>
								  </tr>
								</tbody>
							  </table>
						   </td>
						  </tr>

						</tbody>
					</table>

					</td>
				</tr>

				<tr>
				  <td>
					  
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td width="75%"  style="font-size: 11px;padding: 4px">

						   <table width="100%" class="titulo">
							   
							<thead> <tr> <th width="80%">Concepto </th> <th align="center" width="20%">Valor </th>    
								 </tr>
							</thead>
							<tbody>
								 
						      <tr>
							       <td colspan="1" rowspan="2" align="right">
								  
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
							       <td style="font-size: 16px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center">A pagar</td>
					          </tr>
						      <tr> 
						        <td style="font-size: 16px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center"><?php echo number_format($totalCosto,2,',','.')  ?></td>
							   </tr>
							 <tr>
							   <td colspan="1" align="right">&nbsp;</td>
							   <td align="right" class="precio" >&nbsp;</td>
							   </tr>
							   </tbody>
							</table> 
							
						 </td>
						<td width="25%" valign="top"  style="font-size: 11px;padding: 4px;color: #F50D11;font-style: italic">Emergencias  24 / 7<br>
					Valencia     - 05 2948 102<br>
					El Vergel    - 05 2329 049<br>
					ECU 911</td>
					  </tr>
					  </tbody>
				  </table>
					</td>
				</tr>
				<tr>
				  <td>
					  
					  <table width="90%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td align="center"><img src="../reportes/oscar.png" width="150"/></td>
						<td align="center"><img src="../reportes/maricela.png" width="150"/></td> 
							<td align="center"><img src="../reportes/financiero.png" width="150" height="80" /></td>
					  </tr>
					  <tr>
						<td class="titulo" align="center">Cabo. José Jiménez Troya</td>
						<td class="titulo" align="center">Ing. Maricela Navarro Guerrero </td>
						<td class="titulo" align="center">CPA. Natalia Carrazco</td>
					  </tr>
					  <tr>
						<td class="titulo" align="center">Inspector de Seguridad</td>
						<td class="titulo" align="center">Recaudadora (e)</td>
						<td class="titulo" align="center">Director Financiero (e)</td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E"><b>ORIGINAL CONTRIBUYENTE</b></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
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