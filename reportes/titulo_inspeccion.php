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
    font-size: 12px;
    color: #000000;
    text-align: left;
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
   
 .page table tbody tr td table tbody tr td p {
    font-family: Gotham, Helvetica Neue, Helvetica, Arial, sans-serif;
}
    .page table tbody tr td table tbody tr td p {
    font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif;
}
    .page table tbody tr td table tbody tr td p {
    font-family: Baskerville, Palatino Linotype, Palatino, Century Schoolbook L, Times New Roman, serif;
}
    .page table tbody tr td table tbody tr td h4 em {
    font-family: Cambria, Hoefler Text, Liberation Serif, Times, Times New Roman, serif;
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
									  <td style="font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size: 19px;" ><h4 style="text-align: center; font-size: 13px;"><strong style="font-size: 16px">CUERPO DE BOMBEROS</strong><br>
                                      <em style="font-size: 15px">DEL GADMI DEL CANTÓN SAQUISILÍ</em><br>
                                      <span style="font-size: 13px; font-family: Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">DEPARTAMENTO DE PREVENCION CONTRA INCENDIOS</span> <br>
                                      <span style="font-size: 20px; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif;">PERMISO ANUAL DE FUNCIONAMIENTO</span></h4></td>
									</tr>
								  </tbody>
							  </table>
					  
			      </td>
				</tr>
				<tr>
				  <td align="center">
					  
						<table   style="text-align: justify; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif" width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
						<tr>
						  <td colspan="3" align="center" style="text-align: left; font-size: 12px;"><strong>RUC:</strong> 0560016110001</td>
						  <td width="30%" align="center" style="text-align: left; font-size: 12px;"><strong>AÑO: <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></strong></td>
						  </tr>
						<tr>
						  <td colspan="3" align="center" style="text-align: left; font-size: 12px;">VALOR DE PERMISO DE FUNCIONAMIENTO: <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  <td align="center" style="text-align: left; font-size: 12px;">VALOR AÑOS ANTERIORES:</td>
						  </tr>
						<tr>
						  <td colspan="3"  align="center" class="Mensajep" >VALOR TASA POR INSPECCIÓN/ TIPO DE RIESGO: <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  <td  align="center" class="Mensajep" ><strong>TOTAL PAGADO:<span style="font-size: 22px;padding: 2px;font-weight: bold;background-color: #FFC9CA"><?php echo number_format($totalCosto,2,',','.')  ?></span></strong></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" ><strong>RAZON SOCIAL</strong>: <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" >ACTIVIDAD: <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  </tr>
						<tr>
						  <td width="10%"  align="center" style="text-align: left; font-size: 12px;" >RUC:</td>
						  <td width="40%"  align="center" style="text-align: left; font-size: 12px;" ><span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  <td width="20%"  align="center" style="text-align: left; font-size: 12px;" >INSPECTOR RESPONSABLE:</td>
						  <td  align="center" style="text-align: left; font-size: 12px;" ><span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" >GERENTE O PROPIETARIO:<span class="titulo1"><?php echo $row['sesion_pago'] ?></span></td>
						  </tr>
						<tr>
						  <td  align="center" style="text-align: left; font-size: 12px;" >TELEFONO:</td>
						  <td  align="center" style="text-align: left; font-size: 12px;" > <span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  <td  align="center" style="text-align: left; font-size: 12px;" >CÓDIGO ADM:</td>
						  <td  align="center" style="text-align: left; font-size: 12px;" ><span class="titulo1"><?php echo $row['id_ren_movimiento'] ?></span></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" >DIRECCION DE ESTABLECIMIENTO:<span class="titulo"><?php echo $cliente['direccion'] ?></span></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" ><em>Este departamento, en atención a la solicitud presentada y considerando que en este local se cumplen las disposiciones relativas a la Ley de <strong>DEFENSA</strong> CONTRA INCENDIOS artículo 35, concede el presente <strong>PERMISO DE FUNCIONAMIENTO</strong> válido para el presente año.</em></td>
						  </tr>
						<tr>
						  <td colspan="4"  align="center" style="text-align: left; font-size: 12px;" ><em>Saquisilí, a....... de........ del 20........</em></td>
						  </tr>
						</tbody>
					</table>

					</td>
				</tr>

				<tr>
				  <td align="center" style="font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:14px;"><em style="font-size: 12px"><strong style="font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif">ABNEGACION Y DISCIPLINA</strong></em></td>
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
						<td class="titulo" align="center"><em style="font-size: 12px">PRIMER JEFE DEL CUERPO DE BOMBEROS</em></td>
						<td class="titulo" align="center">&nbsp; </td>
					  </tr>
					</tbody>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" style="font-size: 10px;padding: 3px;color: #7E7E7E">Calle 24, de mMayo-Cdla Obreros Municipals Telefax:(03)2721-031* Emergencias:ECU 911/(03)2721-102 email: bomberos_gadsaquisili@hotmail.com* we:www.bomberossaquisili.gob.ec facebook: Bomberos Saquisili</td>
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