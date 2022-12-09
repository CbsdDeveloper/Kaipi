 <?php 
session_start( );   
require '../kconfig/Db.class.php';   
require '../kconfig/Obj.conf.php';  
 
        $obj     = 	new objects;
        $bd     = 	new Db;
        $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        $sesion 	 =  $_SESSION['login'];
   
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

<head>
    
  <link href="//db.onlinewebfonts.com/c/a278c13b4db68b3ce257ff99fa97893b?family=Epson1" rel="stylesheet" type="text/css"/>
    
  <link rel="stylesheet" href="tike.css">
 

  <script src="script.js"></script>

</head>

<body style="padding-left: 70px">
<script type="text/javascript">
    window.print(this); //dialogo de impresion
	window.onfocus = function(){
		window.close();
	};//cuando regrese el control de foco, cerramos la ventana
 </script>
    
  <div class="ticket" align="center">
     <p class="centrado">FEDERACION DEPORTIVA PROVINCIAL STO DOMINGO TSCHILAS	<br>
       Ruc: 2390001285001<br>
	 STO DOMINGO - ECUADOR<br> 
	  DIR: AV. QUITO 1233 Y RIO BLANCO</p>
      
      <p class="izquierda">Fecha: <?php echo $cabecera['fecha'] ?><br>
      Usuario: <?php  echo $_SESSION['login']?> <br>
	  Transaccion: <?php echo $cabecera['id_movimiento'] ?><br> 
	  Nombre: <?php echo $cabecera['razon'] ?><br> 
      Identificacion: <?php echo $cabecera['idprov'] ?>
      </p>
      
    <table>
      <thead>
        <tr>
          <th class="cantidad">Cantidad</th>
          <th class="producto">Concepto</th>
          <th class="precio">Precio</th>
          <th class="precio">Total</th>    
        </tr>
      </thead>
      <tbody>
     <?php
	$monto_iva = 0; 
	$tarifa_cero  = 0;
	$baseiva = 0; 
   while ($x=$bd->obtener_fila($stmt)){
	$cadena = substr(utf8_decode(trim($x['producto'])),0,60) ;
 	echo '<tr>';  
	echo ' <td class="cantidad"> '.$x['cantidad'].'</td>';   
    echo ' <td class="producto"> '.$cadena.'</td>';
    echo ' <td  class="precio" align="right" >'.number_format($x['costo'],2,',','.').'</td>';   
	echo ' <td  class="precio" align="right" >'.number_format($x['total'],2,',','.').'</td>';
 	echo '</tr>'; 
	$totalCosto += $x['total'];
	$monto_iva  += $x['monto_iva'];
	$tarifa_cero  += $x['tarifa_cero'];
	$baseiva += $x['baseiva'];
   }	  
   
   ?> 
     <tr>
     <td colspan="3" align="right">&nbsp;  </td>
     <td align="right" class="precio"  >&nbsp; </td>
   </tr>
   
    
    
   <tr>
      <td colspan="3" align="right">Total Pagar</td>
      <td align="right" class="precio" ><?php echo round($totalCosto,2) ?></b></td>
  </tr>      
      </tbody>
    </table>
    <p class="centrado">¡GRACIAS ! Documento no valido para declaracion
      <br>Comprobante electronico www.federacionsdt.org<br> <br></p>
  </div>
 </body>

</html>