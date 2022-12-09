<?php
session_start( );

$servidor = 'localhost';
$base_datos = 'liderdoc_kaipi';
$usuario = 'liderdoc_admin';
$password = 'Diesan1803.';
	
$link = '   entra';

echo $link ;
	
 $link=pg_connect("host=".$servidor." dbname=".$base_datos." user=".$usuario." password=".$password);
  

$link = '   ---------- ok';

echo $link ;

echo $link;
 

?>
 
  