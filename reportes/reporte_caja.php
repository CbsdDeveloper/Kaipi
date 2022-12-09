<?php
session_start( );   

    require 'inicio.php';   

   $g  = 	new componente;

   $id =    $_GET["id"];

   $codigo =    $_GET["codigo"];

 

	 

$stmt_detalle =  $g->detalle_movimiento( $codigo );



 $conta = 1;

   while ($row=pg_fetch_assoc($stmt_detalle)){
	 

	       	$file =   trim($row["reporte"]) ;
	 
	    
		   	$file = trim($file).'?id='.$id.'&codigo='. $codigo  ;

		    echo "<script>window.open("."'".$file."'".", '_blank'); </script>";
		   
	 
  	}


 
?>
<script> 

  setTimeout(window.close, 8000);
 
 
</script>	