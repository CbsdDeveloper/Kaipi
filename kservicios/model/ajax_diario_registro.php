<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$fecha        = $_GET['fecha'];
 
$trozos = explode("-", $fecha,3);
       
$anio1 = $trozos[0];
$mes   = $trozos[1];

$nmes  = intval(  $trozos[1] );

$f1 =  $anio1 .'-'.$mes.'-01';

$f2 =   $fecha ;


 echo '<h5><b>Desde: '.$f1.' Hasta: '.$f2.'</b></h5>';  

 
 $aniob = "date_part('year'::text,  fecha)";
 $mesb  = "date_part('month'::text, fecha)";
 
 

$qcabecera = array(
    array(etiqueta => 'Fecha',campo => 'fecha',ancho => '30%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
    array(etiqueta => 'Tipo',campo => 'tipo',ancho => '40%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
    array(etiqueta => 'Asiento',campo => 'id_asiento',ancho => '30%', filtro => 'N', valor => '-', indice => 'S', visor => 'S'),
    array(etiqueta => 'anio',campo =>  $aniob,ancho => '0%', filtro => 'S', valor => $anio1, indice => 'N', visor => 'N'),
    array(etiqueta => 'mes',campo =>   $mesb, ancho => '0%', filtro => 'S', valor => $nmes, indice => 'N', visor => 'N')
   
 );

$acciones = "editar,'',''";
$funcion  = 'goToURLParametro';

 

$bd->JqueryArrayTable('rentas.ren_cuenta_asientos',$qcabecera,$acciones,$funcion,'tabla_config' );


?>
								
 
 
 