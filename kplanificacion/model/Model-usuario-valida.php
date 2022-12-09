<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;
    

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
    $idusuario= strtoupper($_GET['datoUser']);
   
    ///-----------------------------------------
    
    $sql = "SELECT count(*) as EXISTE
                	  FROM STUSUARIOS
                      where USUARIO	 =".$bd->sqlvalue_inyeccion(trim($idusuario), true);
    
    
    $resultado 			= $bd->ejecutar($sql);
    $validaRegistro     = $bd->obtener_array($resultado);
    
    IF ($validaRegistro['EXISTE'] > 0 ){
    	$UsuarioVal = '<b><CENTER> <img src="../../kimages/advertencia.png" />YA EXISTE ESTE USUARIO !!! </CENTER></b>';
    }else{
    	$UsuarioVal = '<b><CENTER>ESTE USUARIO NO EXISTE EN LA BASE DE DATO</CENTER></b>';
    }
    
    echo  $UsuarioVal  
 
  ?> 
								
 
 
 