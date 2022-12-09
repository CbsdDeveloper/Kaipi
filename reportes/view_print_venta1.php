<?php  session_start( );   ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css" media="print">
#Imprime {
 height: auto;
 width: 320px;
 margin: 0px;
 padding: 0px;
 float: left;
 font-family: Arial, Helvetica, sans-serif;
 font-size: 8px;
 font-style: normal;
 line-height: normal;
 font-weight: normal;
 font-variant: normal;
 text-transform: none;
 color: #000;
}
@page{
   margin: 0;
}
small { 
    font-size: smaller;
}
</style>
</head>
<body>
<script type="text/javascript">
    window.print(this); //dialogo de impresion
	window.onfocus = function(){
		window.close();
	};//cuando regrese el control de foco, cerramos la ventana
 </script>

<div id="Imprime">
 <?php 

    require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
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
  <div align="center">  <img src="linea.jpg" width="370" height="10" alt=""/><br>
  <br>
	  <b><div style="font-size: 10px"> MIEL Y CANELA </div></b><br>
     Ruc: 1713960308001<br>
	  Santo Domingo de los Tsachilas<br> 
	  DIR: Av. Quito  1233 y Rio Blanco
  </div>
    .........................................<br>
    Fecha: <?php echo $cabecera['fecha'] ?><br>
    Usuario: <?php  echo $_SESSION['login']?><br>
    Transaccion: <?php echo $cabecera['id_movimiento'] ?><br>
    <br>
    Nombre: <?php echo $cabecera['razon'] ?><br>
    Identificacion: <?php echo $cabecera['idprov'] ?><br><br>
     
    PRODUCTO<br>
    <table width="220" border="0" style="font-size:8px; font-family: Gotham, Helvetica Neue, Helvetica, Arial,' sans-serif'">
  <tr>
     <td>Descripcion</td>
    <td>Cantidad</td>
    <td>Valor</td>
  </tr>
  <?php
	$monto_iva = 0; 
	$tarifa_cero  = 0;
	$baseiva = 0; 
   while ($x=$bd->obtener_fila($stmt)){
	$cadena = substr(utf8_decode(trim($x['producto'])),0,25);
 	echo '<tr>';  
	echo ' <td> '.$cadena.'</td>';
	echo ' <td> '.$x['cantidad'].'</td>';   
	echo ' <td>'.number_format($x['total'],2,',','.').'</td>';
 	echo '</tr>'; 
	$totalCosto += $x['total'];
	$monto_iva  += $x['monto_iva'];
	$tarifa_cero  += $x['tarifa_cero'];
	$baseiva += $x['baseiva'];
   }	  
   
   ?>
   <tr>
     <td colspan="2" align="right">Base Imponible</td>
     <td><?php echo round($baseiva,2) ?></td>
   </tr>
   <tr>
     <td colspan="2" align="right">Base 0%</td>
     <td><?php echo round($tarifa_cero ,2) ?></td>
   </tr>
   <tr>
     <td colspan="2" align="right">Iva 12%</td>  
     <td><?php echo round($monto_iva  ,2) ?></td>
   </tr>
   <tr>
      <td colspan="2" align="right"><span style="font-size: 9px; font-style: normal; font-weight: bold;">Total Pagar</span>:</td>
      <td><b><span style="font-size:9px; font-style: normal; font-weight: bold;"><?php echo round($totalCosto,2) ?></span></b></td>
  </tr>
  </table>
  <br>
<div align="center"><br>
INFORMACION ADICIONAL
Verifique su comprobante electrónico en  la pag. www.g-kaipi.com, la clave es el número de cédula o ruc.
Salido el producto no se aceptan devoluciones.                              
     <br>
	</div>
</div>
 </body>
</html>
