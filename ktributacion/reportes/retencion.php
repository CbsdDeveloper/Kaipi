
<?php session_start( );   

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd;
	global $obj,$parametro;
	global $datos, $total_retencion;
	global $formulario,$idasiento;
    $obj   = 	new objects;
    $bd     = 	new Db;
	$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	$id		= $_GET['a'];

 
 	 $sql = 'SELECT max(a.id_asiento_ref) as id_asiento_ref, max(idprov) as idprov
   				 FROM co_asiento_aux a where  a.id_asiento_aux ='.$bd->sqlvalue_inyeccion($id,true);
	
     $resultado = $bd->ejecutar($sql);
  	 $asiento = $bd->obtener_array( $resultado);
     
	 $idasiento = $asiento['id_asiento_ref'];
     $idprov  = $asiento['idprov'];
	 
	  $sql = "SELECT *
	  FROM view_factura  where id_asiento = ".$bd->sqlvalue_inyeccion($idasiento ,true);
  	 $resultado = $bd->ejecutar($sql);
     $datos = $bd->obtener_array( $resultado); 
	 $fiscal = $datos[ "Fecha Registro"];
     $periodo = explode("-", $fiscal);
	 $anio = $periodo[0]; 
	 
	 /////
	 $IVA = $datos["Monto Iva"];
	 if ($IVA > 0){
	 	 $pone_iva = 'IVA';
		 $monto_iva =$IVA;
		 $bienes = $datos["Retencion 30%"];
		 if ($bienes > 0){
			 $tipo_bienes = 'Bienes';
			 $p30 = '30%';
			 $m30 = $bienes;
			 $total_retencion = $bienes;
		  }
		 $sm1 = $datos["Retencion 70%"];
		 if ($sm1 > 0){
			 $tipo_ser = 'Servicios';
			 $v = '70%';
			 $sm = $sm1;
			 $total_retencion = $total_retencion + $sm1 ;
		  }		  
 		 $sm1 = $datos["Retencion 100%"];
		 if ($sm1 > 0){
			 $tipo_ser = 'Servicios';
			 $v = '100%';
			 $sm = $sm1;
			  $total_retencion = $total_retencion + $sm1 ;
		  }	
  	 }
	 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script language="javascript"> 
function imprimir() 
{ 
if ((navigator.appName == "Netscape")) { 
window.print() ; 
} 
else 
{ 
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = ""; 
} 
} 
</script>
 <style type="text/css">
body,td,th {
	 
	font-size: 12px;
}
<?php
$sql = 'SELECT tipo, vista, header, linea, headerd, grid1, posicion1, posicion2, 
       posicion3, posicion4, posicion5, posicion6, posicion7, posicion8
  FROM co_pcomprobantes
  WHERE TIPO='.$bd->sqlvalue_inyeccion('CR',true);
  
     $resultado = $bd->ejecutar($sql);
  	 $parametro = $bd->obtener_array( $resultado);
	
	 $posicion1 = $parametro["posicion1"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box1 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';
	
	 $posicion1 = $parametro["posicion2"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box2 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';

	 $posicion1 = $parametro["posicion3"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box3 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 	
		
	 $posicion1 = $parametro["posicion4"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box4 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 	

	 $posicion1 = $parametro["posicion5"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box5 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 					
		

	 $posicion1 = $parametro["posicion6"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box6 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 		

	 $posicion1 = $parametro["posicion7"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
 	  
	  echo '.box7 {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 		
 
 	 $posicion1 = $parametro["grid1"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
	 $width = $estilo[2]; 
 
  	  echo '.casilla {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		width: '.$width.';
		}';	 	
 
  	 $posicion1 = $parametro["posicion8"];
	 $estilo = explode(";", $posicion1);
	 $top  = $estilo[0]; 
	 $left = $estilo[1]; 
   	
 	  echo '.total {
		position:absolute;
		top: '.$top.';
		left: '.$left.';
		}';	 
   	
	
	$linea = $parametro["linea"];
	$borde = '';
	 if ($linea == 'S')
	 	$borde = 'border: 1px solid black;';
 	 
	echo 'table, th, td {
		'.$borde.'
		border-collapse: collapse;
		text-align: center;
	}	';
 ?>	
</style>
</head>
<?php 
$vista = $parametro["vista"];
if ($vista == 'S')
	echo '<body>';
else
	echo '<body onload="imprimir();"> ';
?> 
<div class="box1"><?php echo trim($datos['Contribuyente']); ?></div>
<div class="box2"><?php echo trim($datos["Nro Identificacion"]); ?></div>
<div class="box3"><?php echo trim($datos['direccion']); ?></div>
<div class="box4"><?php echo trim($datos['telefono']); ?></div>
<div class="box5"><?php echo trim($datos['Fecha Registro']); ?></div>
<div class="box6">Factura</div>
<div class="box7"><?php echo trim($datos['Nro.Documento']); ?></div>

<div class="casilla">
<table width="100%" border="0" cellspacing="3" cellpadding="4">
<?php 
	$header = $parametro["header"];
	$borde = '';
    if ($header == 'S'){
 	 echo '<tr>';
	 echo trim($parametro["headerd"]);
	 echo '</tr>';
	} 
?> 
  <tr>
    <td rowspan="4" align="left" valign="middle"><?php echo trim($datos['detalle']); ?></td>
    <td rowspan="4" align="center" valign="middle"><?php echo  $anio;  ?></td>
    <td rowspan="2" align="center" valign="middle"><?php echo  $monto_iva;  ?></td>
    <td rowspan="2" align="center" valign="middle"><?php echo  $pone_iva;  ?></td>
    <td align="center" valign="middle"><?php echo $tipo_bienes;  ?></td>
    <td align="center" valign="middle"><?php echo  $p30;  ?></td>
    <td align="center" valign="middle"><?php echo  $m30;  ?></td>
  </tr>
  <tr>			 
    <td align="center" valign="middle"><?php echo $tipo_ser;  ?></td>
    <td align="center" valign="middle"><?php echo  $s;  ?></td>
    <td align="center" valign="middle"><?php echo  $sm;  ?></td>
  </tr>
  
  <?php	
   global $formulario,$idasiento, $total_retencion;		
    $sql = "select codretair, baseimpair, porcentajeair, valretair
			from co_compras_f
			 where  id_asiento =".$bd->sqlvalue_inyeccion($idasiento ,true);
   /*Ejecutamos la query*/
   $stmt = $bd->ejecutar($sql);
   /*Realizamos un bucle para ir obteniendo los resultados*/
 //  $total_retencion = 0;
 	while ($x=$bd->obtener_fila($stmt)){
		echo '<tr>';			 
		echo '<td align="center" valign="middle">'.trim($x['1']).'</td>';
		echo '<td align="center" valign="middle">renta</td>';
		echo '<td align="center" valign="middle">'.trim($x['0']).'</td>';
		echo '<td align="center" valign="middle">'.trim($x['2']).'%</td>';
		echo '<td align="center" valign="middle">'.trim($x['3']).'</td>';
	  echo '</tr>';	
	  $total_retencion = $total_retencion + $x['3'];
	}
 ?>	
</table>
<div class="total"><b> <?php	echo $total_retencion?></b>	</div>
</div>
</body>
</html>
