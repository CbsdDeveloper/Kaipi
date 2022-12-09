<?php   
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    
    
    $qcabecera = array(
        array(etiqueta => 'Id',campo => 'id_regimen',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Regimen',campo => 'regimen',ancho => '50%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Patronal',campo => 'patronal',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Personal',campo => 'personal',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'Reserva',campo => 'reserva',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S'),
        array(etiqueta => 'activo',campo => 'activo',ancho => '10%', filtro => 'N', valor => '-', indice => 'N', visor => 'S') 
    );
    
 
    $acciones = "'','',''";
    $funcion  = '';
    
       
    $bd->JqueryArrayTable('nom_regimen',$qcabecera,$acciones,$funcion,'Tabla_regimen' );
   
    
 
?>