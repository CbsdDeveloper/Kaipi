
<?php session_start( );   

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	require '../../kconfig/convertir.php'; /*Incluimos el fichero de la clase objetos*/	
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd;
	global $obj,$parametro;
	global $datos, $total_retencion;
	global $formulario,$idasiento, $asiento;
    $obj   = 	new objects;
	$bd	   =	Db::getInstance();
	 $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	$id		= $_GET['a'];

 
 	 $sql = 'SELECT a.fechap,a.idprov,a.haber,  b.razon
		FROM co_asiento_aux a, par_ciu b 
		where  a.idprov = b.idprov and a.id_asiento_aux='.$bd->sqlvalue_inyeccion($id,true);
	
     $resultado = $bd->ejecutar($sql);
  	 $datos = $bd->obtener_array( $resultado);
     
 
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
  WHERE TIPO='.$bd->sqlvalue_inyeccion('CH',true);
  
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
		

	 
 ?>	
</style>
</head>
<?php 
$vista = $parametro["vista"];
if ($vista == 'S'){
	echo '<body>';
}else{
	echo '<body onload="imprimir();"> ';
}	
 	$monto_imprime = 0;
	$monto_imprime = (float) $datos['haber'] ;
    $imprime = (convertir($monto_imprime)). ' dólares --------------------------------------------' ;	
?> 
<div class="box1"><?php echo trim($datos['razon']); ?></div>
<div class="box2"><?php echo trim($datos["haber"]); ?></div>
<div class="box3"><?php echo trim($imprime); ?></div>
<div class="box4"><?php echo trim($_SESSION['ciudad']); ?></div>
<div class="box5"><?php echo trim($datos['fechap']); ?></div>
 
</body>
</html>

 