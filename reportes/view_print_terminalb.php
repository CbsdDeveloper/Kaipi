<?php 
session_start( );  
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';
 
$bd     = 	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$fecha 			= date("Y/m/d H:i:s"); 
$id_ingreso		= $_GET['id'];
   

$cabecera 	= $bd->query_array('rentas.view_ren_movimiento_web','*', 'id_ren_movimiento='.$bd->sqlvalue_inyeccion( $id_ingreso	,true)); 

$xx         = $bd->query_array('par_usuario','login, email ,completo', 'email='.$bd->sqlvalue_inyeccion(trim($cabecera['sesion']),true)); 

 
?> 
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
	
	
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
	
	  <style>
	
	* {
   font-family: 'Courier New';
}
	 
		  </style>
		  
</head>		
<body leftmargin="20px" onload="imprimir();">  
	
 <p style="font-size: 14px;font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'">
	   EMPRESA PUBLICA MUNICIPAL DEL MINI TERMINAL  TERRESTRE DE LA CIUDAD DE BAHIA DE CARAQUEZ<BR>RUC 1360064950001</p>
	
<p style="font-size: 10px;font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'">
		  AV. SIXTO DURAN BALLEN<BR>
		  TELEFONO: 05 2398345<BR>
		  CORREO: emttbc@gmail.com<BR>
		  BAHIA DE CARAQUEZ- SUCRE - ECUADOR
	 </p>
	 
	  <p style="font-size: 12px;font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'">
	   <br>   
	    <?php  echo $cabecera['nombre_rubro'].' $ '. $cabecera['apagar'] ?> <br>
		<?php  echo $cabecera['contribuyente'] ?> <br>
		<?php  echo $cabecera['comprobante'] ?> <br>  
		<?php  echo $cabecera['detalle'] ?> <br>  
 	 </p>
		  <p style="font-size: 12px;font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'">
	   <br>
	   ------------------------------------------<br>		  
	   FECHA    : <?php  echo $cabecera['fecha'] ?><br>
	   IMPRESION: <?php  echo $fecha  ?><br>
	   USUARIO: <?php    echo $xx['completo'] ?><br>			  
 	 </p>
      <br> <br> <br>
	
	 
	 </body>
</html>
 