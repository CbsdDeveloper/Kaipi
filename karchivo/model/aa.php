<?php
	session_start( );
	
	 

	$array_dato = array();
 
	$array_dato_detalle = array();
 
 
    $i =0;
	$xml=simplexml_load_file("Factura.xml");
	 
 
	  foreach ( $xml->children() as $child ) {

		$array_dato[$i] = $child;

		$datosMotivos[] = $child;
		$i++;
}
 
 
$array_dato_detalle  =  $array_dato[2] ;

//  print_r( $datosMotivos  );
 

 
foreach($array_dato_detalle as $equipo)
 	{
 
 	foreach($equipo as $jugador)
 		{
 	 
  
		echo $jugador.'<br>' ;

 		}
 	echo "<br>";
 	}
 
 
  

?>	