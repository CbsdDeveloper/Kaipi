<?php 
session_start( );  
ob_start(); 
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';
$obj     = 	new objects;
$bd     = 	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

  $fecha = date("Y/m/d H:i:s"); 
  $idSucursal = 'sas'; //se obtiene la sucursal respecto al usuario que inicio sesion
  $totalV = 0;
  $totalCosto =0;
  $totalImporte=0;
  
  $id_ingreso		= $_GET['codigo'];
   
  // detalle
  $sql1 = "SELECT id, codigo, producto, unidad, cantidad, costo, total, tipo, monto_iva, tarifa_cero, tributo, baseiva, sesion
	  			 FROM  view_factura_detalle where id_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
 				
	 /*Ejecutamos la query*/
	 $stmt = $bd->ejecutar($sql1);
  
    // cabecera del comprobante
  	  $sql = "SELECT id_movimiento, fecha, registro, detalle, sesion, creacion, comprobante, estado, tipo, id_periodo, documento, 					idprov, id_asiento_ref, proveedor, razon, direccion, telefono, correo, contacto, fechaa, anio, mes, transaccion
	  			FROM  view_inv_movimiento
					where  id_movimiento= ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
			   
  	  $resultado_cab = $bd->ejecutar($sql);
      $cabecera = $bd->obtener_array( $resultado_cab); 
?> 
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
	  <link rel="stylesheet" href="tike.css">
</head>		
<body class="ticket">
   
      <br>
	  <p class="izquierda">Gobierno Autonomo Descentralizado Municipal Nabon 	<br>
       Ruc: 0160000108001<br>
	 NABON - ECUADOR<br> 
	  DIR: AV. Manuel Ullauri Q <br> 2227033</p>
	
<p class="izquierda">Fecha: <?php echo $cabecera['fecha'] ?><br>
      Usuario: <?php  echo $_SESSION['login']?> <br>
	  Transaccion: <?php echo $cabecera['comprobante'] ?><br> 
	  Nombre: <?php echo $cabecera['razon'] ?><br> 
      Identificacion: <?php echo $cabecera['idprov'] ?><br> <br> 
	  
      </p>
	
	
    <table with='100%'>
      <thead>
        <tr>
          <th width="60%">Concepto </th>
          <th width="40%">Valor </th>    
        </tr>
      </thead>
      <tbody>
     <?php
	$monto_iva = 0; 
	$tarifa_cero  = 0;
	$baseiva = 0; 
    $i=1;
   while ($x=$bd->obtener_fila($stmt)){
	$cadena = substr(utf8_decode(trim($x['producto'])),0,100) ;
 	echo '<tr>';  
    echo ' <td> '.$cadena.'</td>';
	echo ' <td>'.number_format($x['total'],2,',','.').'</td>';
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
       <td colspan="1" align="right">Total a Pagar</td>
       <td ><?php echo round($totalCosto,2) ?></td>
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
    </table>
	Recaudado por: <?php  echo $_SESSION['login']?> 
	<br>
	Fecha Impresion: <?php  echo date("Y-m-d"); ?> 
	<br><br>
	 GRACIAS...Documento no valido para declaracion
      <br>Comprobante electronico www.nabon.gob.ec 
 
</body>
</html>
<?php 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A5', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
