<?php 
session_start( );  
ob_start(); 
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

$bd     = 	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

/*
  $fecha = date("Y/m/d H:i:s"); 
  $idSucursal = 'sas';  
  $totalV = 0;
  $totalCosto =0;
  $totalImporte=0;
  */

  $id_ingreso		= $_GET['codigo'];
   
  // detalle
  $sql1 = "SELECT id, codigo, producto, unidad, cantidad, costo, total, 
                  tipo, monto_iva, tarifa_cero, tributo, baseiva, sesion
	  	     FROM  view_factura_detalle 
			WHERE id_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
 				
	 /*Ejecutamos la query*/
	 $stmt = $bd->ejecutar($sql1);
  
    // cabecera del comprobante
  	  $sql = "SELECT id_movimiento, fecha, registro, detalle, sesion, creacion,
                     comprobante, estado, tipo, id_periodo, documento, idprov, 
                     id_asiento_ref, proveedor, razon, direccion, telefono, correo, 
                     contacto, fechaa, anio, mes, transaccion
	  			FROM  view_inv_movimiento
			   WHERE id_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
			   
  	  $resultado_cab = $bd->ejecutar($sql);
  	  
      $cabecera      = $bd->obtener_array( $resultado_cab); 
 
$xx = $bd->query_array('par_usuario','login, email ,completo', 'email='.$bd->sqlvalue_inyeccion(trim($cabecera['sesion']),true)); 
?> 
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
	 
</head>		
<body>

	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px">
  <tbody>
    <tr>
      <td colspan="4" style="padding-top: 50px">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right" style="font-size: 14;font-weight: 650">PERMISO Nro: <?php echo $cabecera['comprobante'] ?></td>
          </tr>
          <tr>
            <td>Fecha:</td>
            <td><span class="izquierda"><?php echo $cabecera['fecha'] ?></span></td>
            <td align="right">Valido hasta: 31 de Diciembre  <?php echo $cabecera['anio'] ?></td>
          </tr>
          <tr>
            <td width="10%">Cedula:</td>
            <td width="50%"><span class="izquierda"><?php echo $cabecera['idprov'] ?></span></td>
            <td width="40%">&nbsp;</td>
          </tr>
          <tr>
            <td>Nombre:</td>
            <td><span class="izquierda"><?php echo $cabecera['razon'] ?></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Dirección:</td>
            <td><span class="izquierda"><?php echo $cabecera['direccion'] ?></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Teléfono:</td>
            <td><span class="izquierda"><?php echo $cabecera['telefono'] ?></span></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Detalle:</td>
            <td><span class="izquierda"><?php echo $cabecera['detalle'] ?></span></td>
            <td><span class="izquierda" style="font-size: 10px;color: #4D4D4D">CAJA:
                <?php  echo $xx['completo']?>
            </span></td>
          </tr>
          <tr>
            <td colspan="3"><hr></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
		  <table width="100%">
      <thead>
        <tr>
             <th align="center" width="40%">Concepto </th>
			 <th align="center" width="20%">Cantidad </th>
             <th align="center" width="20%">Valor </th>    
			 <th align="center" width="20%">Total </th>    
        </tr>
      </thead>
      <tbody>
     <?php
	$monto_iva = 0; 
	$tarifa_cero  = 0;
	$baseiva = 0; 
    $i=1;
   while ($x=$bd->obtener_fila($stmt)){
	$cadena = substr( (trim($x['producto'])),0,250) ;
 	echo '<tr>';  
       echo ' <td> '.$cadena.'</td>';
	   echo ' <td align="center" >'.number_format($x['cantidad'],0,',','.').'</td>';
	   echo ' <td align="center" >'.number_format($x['costo'],2,',','.').'</td>';
	   echo ' <td align="center" >'.number_format($x['total'],2,',','.').'</td>';
 	echo '</tr>'; 
	$totalCosto += $x['total'];
	$monto_iva  += $x['monto_iva'];
	$tarifa_cero  += $x['tarifa_cero'];
	$baseiva += $x['baseiva'];
	   $i++;
   }	 
		  
   $conta = 5- $i;

	for ($i = 1; $i < $conta; $i++) {
     
		echo '<tr>    <td colspan="1" >&nbsp;  </td>    <td align="right" class="precio"  >&nbsp; </td>  </tr>';
		
    }
		  
?> 
		  
     <tr>
       <td colspan="3" style="font-weight: 800"  align="right">A PAGAR $.</td>
       <td align="center" style="font-size: 14px;font-weight: 700;border: 1px solid #090909" ><?php echo round($totalCosto,2) ?></td>
     </tr>
     <tr>
       <td colspan="1" align="right">&nbsp;</td>
       <td align="right" class="precio" >&nbsp;</td>
     </tr>
     <tr>
       <td colspan="1" align="right">&nbsp;</td>
       <td align="right" class="precio" >&nbsp;</td>
     </tr>
      </tbody>
    </table></td>
    </tr>
    <tr>
      <td colspan="4">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td  align="center">CI.............................</td>
    </tr>
    <tr>
      <td align="center">Dpto. Prevención</td>
      <td  align="center">Dpto. Contable</td>
      <td  align="center">Recibi Conforme</td>
    </tr>
  </tbody>
</table>

		
		</td>
    </tr>
  </tbody>
</table><br>
	 </body>
</html>
<?php 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('a4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));
	
if (ob_get_length()) ob_end_clean();
	

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
$filename = "Comprobante_".time().'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
