<?php 
session_start( );  
ob_start(); 
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';
$obj     = 	new objects;
$bd     = 	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
$fecha 			= date("Y/m/d H:i:s"); 
$totalV 		= 0;
$totalCosto 	= 0;
$totalImporte	= 0;
$id_ingreso		= $_GET['codigo'];
// detalle
$sql1 			= "SELECT * FROM  rentas.view_ren_movimiento_det WHERE id_ren_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
$stmt 			= $bd->ejecutar($sql1);
$concepto 		= ''; 
while ($x=$bd->obtener_fila($stmt)){
	$concepto   = $concepto.' '.trim($x['producto']) ;
}
// cabecera del comprobante
$sql 		    = "SELECT * FROM  rentas.view_movimiento_periodo WHERE  id_ren_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
$resultado_cab  = $bd->ejecutar($sql);
$cabecera 		= $bd->obtener_array( $resultado_cab); 
$xx 			= $bd->query_array('par_usuario','login, email ,completo', 'email='.$bd->sqlvalue_inyeccion(trim($cabecera['sesion']),true)); 
$detalle  		= $cabecera['detalle'];

$sql2 			= "SELECT * FROM  rentas.view_movimiento_var WHERE  imprime = 'S' and id_ren_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
$stmt2 			= $bd->ejecutar($sql2);
$adicional 		= ''; 
while ($x=$bd->obtener_fila($stmt2)){
	$adicional   = $adicional.' '.trim($x['nombre_variable']) . ' '.trim($x['valor_variable']) ;
}
$detalle		= strtoupper($detalle).' '.strtoupper ($adicional);
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<style type="text/css">

 
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
	
	@page { size: A4; margin: 0; }

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
	<div class="page" align="center">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td>
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td colspan="4" align="center"><b><span style="font-size: 15px"><?php echo strtoupper($concepto) ?></span></b></td>
              </tr>
            <tr>
              <td colspan="4"  align="center" ><span class="Mensajep">Periodo <?php echo $cabecera['anio'] ?></span></td>
              </tr>
            <tr>
               <td  class="titulo" width="10%">Identificacion</td>
              <td  class="titulo"  width="40%"><?php echo $cabecera['idprov'] ?></td>
              <td  class="titulo"  width="10%" align="right">Nro. Emision</td>
              <td  class="titulo"  width="40%"><?php echo $id_ingreso ?></td>
              </tr>
            <tr>
              <td  class="titulo"  >Contribuyente</td>
              <td  class="titulo"  ><?php echo $cabecera['razon'] ?></td>
              <td  class="titulo"  align="right">Nro.Comprobante</td>
              <td   class="titulo" ><?php echo $cabecera['comprobante'] ?></td>
              </tr>
            <tr>
              <td  class="titulo" >Dirección</td>
              <td  class="titulo"  ><?php echo $cabecera['direccion'] ?></td>
              <td  class="titulo"  align="right">Emision</td>
              <td   class="titulo"  ><?php echo $cabecera['fechaa'] ?></td>
              </tr>
            <tr>
              <td  class="titulo" >Concepto</td>
              <td  class="titulo"  ><span class="titulo1"><?php echo $concepto ?></span></td>
              <td  class="titulo"  align="right"><span class="titulo1">Usuario</span></td>
              <td   class="titulo"  ><?php echo $xx['completo'] ?></td>
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
                      <td  bgcolor="#FBFBFB"   class="titulo1"><?php echo $detalle ?></td>
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
					 <?php
					$stmt3 			= $bd->ejecutar($sql1);
					$monto_iva 		= 0; 
					$tarifa_cero  	= 0;
					$baseiva 		= 0; 
					$i				= 1;
				   while ($x=$bd->obtener_fila($stmt3)){
							$cadena = trim($x['producto']);
							echo '<tr>'.' <td> '.$cadena.'</td>';
							echo ' <td  align="center">'.number_format($x['total'],2,',','.').'</td>';
							echo '</tr>'; 
							$totalCosto 	+= $x['total'];
							$monto_iva  	+= $x['monto_iva'];
							$tarifa_cero  	+= $x['tarifa_cero'];
							$baseiva 		+= $x['baseiva'];
					    $i++;
				   }	 
				    $conta = 5- $i;
					for ($i = 1; $i < $conta; $i++) {
							echo '<tr>    <td colspan="1" >&nbsp;  </td>    <td align="right" class="precio"  >&nbsp; </td>  </tr>';
					}
 			 ?> 
				 <tr> <td colspan="1" align="right">Total a Pagar</td>
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
      <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="center"><img src="../reportes/oscar.png" width="150"/></td>
            <td align="center"><img src="../reportes/maricela.png" width="150"/></td> 
            <td align="center"><img src="../reportes/financiero.png" width="150" height="77" /></td>
          </tr>
          <tr>
            <td class="titulo" align="center">Cabo. Jose Jimenez </td>
            <td class="titulo" align="center">Ing. Maricela Navarro </td>
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
	<p>&nbsp;</p>
 	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td>
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td colspan="4" align="center"><b><span style="font-size: 15px"><?php echo strtoupper($concepto) ?></span></b></td>
              </tr>
            <tr>
              <td colspan="4"  align="center" ><span class="Mensajep">Periodo <?php echo $cabecera['anio'] ?></span></td>
              </tr>
            <tr>
               <td  class="titulo" width="10%">Identificacion</td>
              <td  class="titulo"  width="40%"><?php echo $cabecera['idprov'] ?></td>
              <td  class="titulo"  width="10%" align="right">Nro. Emision</td>
              <td  class="titulo"  width="40%"><?php echo $id_ingreso ?></td>
              </tr>
            <tr>
              <td  class="titulo"  >Contribuyente</td>
              <td  class="titulo"  ><?php echo $cabecera['razon'] ?></td>
              <td  class="titulo"  align="right">Nro.Comprobante</td>
              <td   class="titulo" ><?php echo $cabecera['comprobante'] ?></td>
              </tr>
            <tr>
              <td  class="titulo" >Dirección</td>
              <td  class="titulo"  ><?php echo $cabecera['direccion'] ?></td>
              <td  class="titulo"  align="right">Emision</td>
              <td   class="titulo"  ><?php echo $cabecera['fechaa'] ?></td>
              </tr>
            <tr>
              <td  class="titulo" >Concepto</td>
              <td  class="titulo"  ><span class="titulo1"><?php echo $concepto ?></span></td>
              <td  class="titulo"  align="right"><span class="titulo1">Usuario</span></td>
              <td   class="titulo"  ><?php echo $xx['completo'] ?></td>
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
                      <td  bgcolor="#FBFBFB"   class="titulo1"><?php echo $detalle ?></td>
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
					 <?php
					$stmt3 			= $bd->ejecutar($sql1);
					$monto_iva 		= 0; 
					$tarifa_cero  	= 0;
					$baseiva 		= 0; 
					$i				= 1;
					$totalCosto = 0;
				   while ($x=$bd->obtener_fila($stmt3)){
							$cadena = trim($x['producto']);
							echo '<tr>'.' <td> '.$cadena.'</td>';
							echo ' <td  align="center">'.number_format($x['total'],2,',','.').'</td>';
							echo '</tr>'; 
							$totalCosto 	+= $x['total'];
							$monto_iva  	+= $x['monto_iva'];
							$tarifa_cero  	+= $x['tarifa_cero'];
							$baseiva 		+= $x['baseiva'];
					    $i++;
				   }	 
				    $conta = 5- $i;
					for ($i = 1; $i < $conta; $i++) {
							echo '<tr>    <td colspan="1" >&nbsp;  </td>    <td align="right" class="precio"  >&nbsp; </td>  </tr>';
					}
 			 ?> 
				 <tr> <td colspan="1" align="right">Total a Pagar</td>
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
      <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td align="center"><img src="../reportes/oscar.png" width="150"/></td>
            <td align="center"><img src="../reportes/maricela.png" width="150"/></td> 
            <td align="center"><img src="../reportes/financiero.png" width="150" height="77" /></td>
            </tr>
          <tr>
            <td class="titulo" align="center">Cabo. Jose Jimenez </td>
            <td class="titulo" align="center">Ing. Maricela Navarro </td>
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
    </tbody>
</table>
 	</div>		

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