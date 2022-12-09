<?php   
session_start(); 
 
include ('../../kconfig/Db.class.php');   

include ('../../kconfig/Obj.conf.php'); 
	
$bd	   =	    new Db ;
   
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
$cedula = $_GET['cedula'];

  
    $Avalido = $bd->query_array('par_ciu',
                                         'count(idprov) as nn', 
                                         'idprov='.$bd->sqlvalue_inyeccion($cedula,true)
        );
    
    if ($Avalido['nn'] == 0 ){
        $idprov = $cedula;
    }else{
        $idprov = 'YA_EXISTE';
    }
    
  
    echo $idprov;
     
 ?>