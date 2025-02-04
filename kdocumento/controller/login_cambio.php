<?php
session_start( );
$_SESSION['us'] = '';
$_SESSION['ac']= '';	
require '../../kconfig/Obj.conf.php'; 
require '../../kconfig/Db.class.php';  

$bd	     =	new Db;
$obj     = 	new objects;
$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$tipo  = 'principal';

$sql11 = "SELECT a.ruc_registro, a.url,a.razon, b.nombre,a.fondo
		    FROM web_registro a , par_catalogo b
		   WHERE b.idcatalogo =  a.idciudad and a.tipo =".$bd->sqlvalue_inyeccion($tipo ,true);
 
 
$resultado1  = $bd->ejecutar($sql11);
$datos11     = $bd->obtener_array( $resultado1);

 
$_SESSION['sesion_actual']  = 0;
$_SESSION['ruc_registro']   =  trim($datos11['ruc_registro']);
$_SESSION['logo']	 	    =  trim($datos11['url']);
$_SESSION['razon'] 	        =  trim($datos11['razon']);
$_SESSION['ciudad'] 		=  trim($datos11['nombre']);
$_SESSION['tiempo'] 		=  date('Y-m-d H:i:s'); 
$_SESSION['fondo']		    =  $datos11['fondo'];
$_SESSION['captcha']        = 1;

 
		 
		    $user 		= $_POST['username'];
			$password 	= $_POST['password'];
			//---------------------------------------------variable------------------------------------
			$clave = $obj->var->_codifica(trim($password));
			//---------------------------------------------variable------------------------------------
 			$datos = $bd->query_array('par_usuario',    
			    'login,email,rol,url,idusuario ,enlace',   
			    'login='.$bd->sqlvalue_inyeccion($user,true). ' and 
				 clave='.$bd->sqlvalue_inyeccion(trim($clave),true)
			    );
  			//---------------------------------------------EJECUCION------------------------------------
  			$anio = date("Y");
  			$_SESSION['anio'] 		= $anio;
 			 
 			    
 			 if (!empty($datos[0])){     
 			 						         	$_SESSION['login'] 		= $datos['login'];
			 						         	$_SESSION['email'] 		= $datos['email'];
			 						         	$_SESSION['rol']   		= $datos['rol'];
			 						         	$_SESSION['foto']  		= $datos['url'];
			 						         	$_SESSION['usuario']    = $datos['idusuario'];
 			 						          
			 						         	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/inicio">';
 			 						         	 
 			 }else{
  	                echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/inicio">';
 			 }
                
          
?>