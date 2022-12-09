<?php 
session_start();  

ob_start(); 
 



require 'ktitulo.php';   /*Incluimos el fichero de la clase Db*/
 	

$g  			= new ReportePdf;

$id_ingreso		 = $_GET['id']; 

$cliente 	 	 = $g->_ciu($_GET["id"]);
   
$titulos 		 = $g->_titulos_pagos(  $_GET["id"], $_GET["codigo"]);
	

$g->QR_DocumentoDoc($id_ingreso); 


?> 
<!doctype html>
<html>
<head>
	
<meta charset="utf-8">

	
	<style type="text/css">

	@page { size: A5; margin: 0; }
	
 
	* { box-sizing: border-box; -moz-box-sizing: border-box; } 
	
	.page { 
		width: 21cm; 
		min-height: 29.7cm; 
		padding-right: 0.1cm; 
		padding-left: 0.1cm;
		padding-bottom:  0.8cm;
		padding-top:  0.1cm;	
		/*margin: 1cm auto; */
		} 
	
	.titulo2 {	padding-left: 5px;
	padding-bottom: 2px;
	font-size: 11px;
}
.titulo2 {	padding-left: 5px;
	padding-bottom: 2px;
	font-size: 11px;
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
    padding-left: 2px;
    padding-bottom: 2px;
    font-size: 15px;
	font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; 
  	}
 
	.titulo1{
	padding-left: 7px;
	padding-top: 3px;
	padding-bottom: 3px;
	font-size: 12px;
  	}
   
 </style>
	
	
	<script type="text/javascript">
		
            function imprimir() {
				
                if (window.print) {
					
                    window.print();
					
				    window.onafterprint = window.close;

					
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
 
</head>


	
	
<body onload="imprimir();">
 

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
									  <td style="text-align: justify; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:19px;">En el uso de sus atribuciones establecidas en la Ley de Defensa Contra incendios, en su Art. 35 concede el presente Permiso de Funcionamiento: </td>
									</tr>
								  </tbody>
							  </table>
					  
			      </td>
				</tr>
				<tr>
				  <td align="center">
					  
						<table   style="text-align: justify; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif" width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
						<tr>
						  <td colspan="4" align="center">&nbsp;</td>
						  </tr>
						<tr>
						  <td colspan="4" align="center"><b><span style="font-size: 15px"><?php echo strtoupper($row['nombre_rubro']) ?></span></b></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" class="Mensajep" ><span style="font-weight: bold">Periodo</span> <?php echo $row['anio'] .'-'.$row['mes'] ?></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" >&nbsp;</td>
						  </tr>
						<tr>
						   <td  class="titulo1" width="10%">Identificacion</td>
						  <td  class="titulo"  width="50%"><?php echo $cliente['idprov'] ?></td>
						  <td  class="titulo1"  width="10%" align="right">Nro. Emision</td>
						  <td  class="titulo1"  width="30%"><?php echo $row['id_ren_movimiento'] ?></td> 
						  </tr>
						<tr>
						  <td  class="titulo1">Contribuyente</td>
						  <td  class="titulo"><?php echo $cliente['razon'] ?></td>
						  <td  class="titulo1"  align="right">Emision </td>
						  <td   class="titulo1"><?php echo $row['fecha'] ?></td>
						  </tr>
						<tr>
						  <td rowspan="2"  class="titulo1" valign="top" >Dirección</td>
						  <td rowspan="2"  class="titulo" valign="top"  ><?php echo $cliente['direccion'] ?></td>
						  <td class="titulo1"  align="right">Usuario</td>
						  <td class="titulo1"><?php echo $row['sesion_pago'] ?></td>
						  </tr>
						<tr>
						  <td  class="titulo1"  align="right">Impresion</td>
						  <td  class="titulo1"><?php echo date('Y-m-d') ?></td>
						</tr>
						<tr>
							<td colspan="4"  class="titulo1" > <?php echo $detalle ?></td>
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
											  <td  class="titulo1">Detalle</td>
											  <td  class="titulo1">Monto</td>
											</tr>
											 	<?php	
													    $totalCosto = 0;
														$monto_iva  = 0;
														$tarifa_cero = 0;
														$baseiva = 0;
			
													$codigo = $row['id_ren_movimiento'];
												    $stmt3  = $g->_detalle_rubros($codigo,$_GET["codigo"]);
			
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
							       <td style="font-size: 18px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center">A pagar</td>
					          </tr>
						      <tr> 
						        <td style="font-size: 22px;padding: 2px;font-weight: bold;background-color: #FFC9CA" align="center"><?php echo number_format($totalCosto,2,',','.')  ?></td>
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
				  <td align="center" style="text-align: center; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif;font-size:14px;">Por haber llenado todos los requisitos puntualizados en el Reglamento General, de dicha Ley,<br>
			      Observaciones:</td>
				  </tr>
				<tr>
				  <td align="center" style="font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:14px;">ABNEGACION Y DISCIPLINA</td>
				  </tr>
				<tr>
				  <td align="center">
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					  <tr>
						<td width="20%" align="left" class="titulo"><img width="80" height="80" src='logo_qr.png'/> </td>
						<td width="60%" align="center" class="titulo"><img src="firma_sigsig.png" width="180" height="93" /></td>
						<td width="20%" align="center"><span style="font-size: 9px;padding: 3px;color:#9A9797"><b>ORIGINAL CONTRIBUYENTE</b></span></td>
					  </tr>
					  <tr>
						<td class="titulo" align="center">&nbsp; </td>
						<td class="titulo" align="center">PRIMERA JEFATURA</td>
						<td class="titulo" align="center">&nbsp; </td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E">&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
			  </tbody>
			</table>

				<p>&nbsp;</p>
 

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