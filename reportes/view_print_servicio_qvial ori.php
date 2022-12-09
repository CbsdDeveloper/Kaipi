<?php 
session_start( );  
ob_start(); 
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

$bd     = 	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

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
	  <link rel="stylesheet" href="tike.css">
</head>		
<body class="ticket">
   
      <br>
	  <p class="izquierda">EMPRESA QUEVIAL EP	<br>
       Ruc: 1260050080001<br>
	 QUEVEDO - ECUADOR<br> 
	  DIR: AV. SAN RAFAEL Y WALTER ANDRADE <br> 052762539 - 0527576972</p>
	
<p class="izquierda">Fecha: <?php echo $cabecera['fecha'] ?><br>
      Caja: <?php  echo $xx['completo']?> <br>
	  Transaccion: <?php echo $cabecera['comprobante'] ?><br> 
	  Nombre: <?php echo $cabecera['razon'] ?><br> 
      Identificacion: <?php echo $cabecera['idprov'] ?><br> <br> 
	  Detalle Adicional<br> 
	  <?php echo $cabecera['detalle'] ?>
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
	$cadena = substr( (trim($x['producto'])),0,100) ;
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
	Recaudado por: <?php  echo $xx['completo'] ?> 
	<br>
	Fecha Impresion: <?php  echo date("Y-m-d"); ?> 
	<br><br>
	Impreso por: <?php  echo $_SESSION['login']?> 
	<br><br>
	 GRACIAS...Documento no valido para declaracion
      <br>Comprobante electronico www.quevial.gob.ec 
 
</body>
</html>
<?php 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A5', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));
	
if (ob_get_length()) ob_end_clean();
	

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
$filename = "Comprobante_".time().'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 
?>
