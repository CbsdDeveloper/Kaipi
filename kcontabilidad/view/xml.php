<?php
	session_start( );
?>	
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
 <?php
 
	  require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
  
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/ 	 
 
   
 
    $obj   = 	new objects;
	$bd	   =	new Db;
    $sesion 	 = $_SESSION['login'];
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
	 
	//$myfile = fopen("2006201801099215640600120190030001522250015222511.xml", "r") or die("Unable to open file!");
	
	$myfile = fopen("2705201801179125123.xml", "r") or die("Unable to open file!");
	
	
	
	$i = 0;
 
// Output one line until end-of-file
while(!feof($myfile)) {
	 	
	 $linea = fgets($myfile, 140) ;
	
 	if ( $i <= 150 ){
 	//htmlspecialchars_decode
		
		 $linea = htmlspecialchars_decode($linea);
			 
		 $sql = "INSERT INTO xml_sesion ( sesion, etiqueta) values (".
					  $bd->sqlvalue_inyeccion($sesion, true).",".
					  $bd->sqlvalue_inyeccion( $linea, true).")";   

          $bd->ejecutar($sql);
 
	}	
	
	$i++;
	

}
	
fclose($myfile);
	
	//	$autorizacion = new SimpleXMLElement('Factura.xml', null, true);
  /*
	$xmlDoc = new DOMDocument();
	
    $xmlDoc->load("2006201801099215640600120190030001522250015222511.xml");

$x = $xmlDoc->documentElement;
	
foreach ($x->childNodes AS $item) {
	
    print   $item->nodeValue . "<br>";

/*	foreach ($item->childNodes AS $item1) {
	
					print $item1->nodeName . " = " . $item1->nodeValue . "<br>";


	}
	

}
 
*/	
	
 	/*
	
	 
 $xml = file_get_contents('Factura.xml');
	
 $sxe = new SimpleXMLElement($xml);
 
   
	foreach($sxe as $usuario) {
		
    	echo $usuario.'<br>';
		
 
}
	
	
	

	foreach ($sxe->children() as $persona) {

    		foreach ($persona->children() as $dat) {
				
					echo $dat->infoTributaria. "<br>";
    
				}
     }
	*/
	
 
	/*
$item = $sxe->xpath('//comprobante');
 
foreach ($item as $i) {
    
	$att = $i->attributes();
	
    $item[(string) $att['name']] = (string) $i;
	
	echo $item['0'].'<br>';
}
 
*/
	 
?>	
</body>
</html>