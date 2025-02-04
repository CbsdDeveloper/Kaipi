<?php

session_start( );

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

/*Creamos la instancia del objeto. Ya estamos conectados*/
$_SESSION['us'] = '';
'' = '';
$_SESSION['ac'] = '';

$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 $tipo = 'principal';

$sql11 = "SELECT a.ruc_registro, a.url,a.razon, b.nombre
				    						FROM web_registro a , par_catalogo b
				    						where b.idcatalogo =  a.idciudad and a.tipo =".$bd->sqlvalue_inyeccion($tipo ,true);



$resultado1 = $bd->ejecutar($sql11);
$datos11     = $bd->obtener_array( $resultado1);

$_SESSION['ruc_registro'] =  $datos11['ruc_registro'];
$_SESSION['logo']	 	    =  $datos11['url'];
$_SESSION['razon'] 	    =  $datos11['razon'];
$_SESSION['ciudad'] 		=  $datos11['nombre'];
$_SESSION['tiempo'] = time();
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
if (isset($_POST['s'])){
			$security = $_POST['s'];
		    $user 		= @$_POST['username'];
			$password 	= @$_POST['password'];
			$codigos 	= @$_POST['codigos'];
			//---------------------------------------------variable------------------------------------
			$clave = $obj->var->_codifica($password);
			$pos = strpos($user, '@');
			//---------------------------------------------variable------------------------------------
			if ($security == 'register'){
					if($codigos == $_SESSION['captcha']){
								if ($pos === false) {
									$sql='SELECT login,email,rol,url,idusuario  FROM par_usuario
					    					  WHERE login='.$bd->sqlvalue_inyeccion($user,true). ' and clave='.$bd->sqlvalue_inyeccion($clave,true);
									
								} else {
 									$sql='SELECT login,email,rol,url,idusuario  FROM par_usuario
					    					  WHERE  email='.$bd->sqlvalue_inyeccion($user,true). ' and clave='.$bd->sqlvalue_inyeccion($clave,true);
								}
							
								 $stmt = $bd->ejecutar($sql);
 						         $datos=$bd->Arrayfila($stmt);
 						        
 						         //-------------------------------------------------------------------------------------------------------------------------
 						         if (!empty($datos)){
			 						         	$_SESSION['login'] = $datos['0'];
			 						         	$_SESSION['email'] = $datos['1'];
			 						         	$_SESSION['rol']   = $datos['2'];
			 						         	$_SESSION['foto']  = $datos['3'];
			 						         	$_SESSION['usuario']  = $datos['4'];
 			 						         	 echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/View-panel">';
 						         }
 						         else
 						         {
 						         	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/login">';
 						         }
 					//-------------------------------------------------------------------------------------------------------------------------
		        	}else{
				        echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/login">';
 		          }
             }else 
             {
              echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/login">';
              }
	
}

 

?>
 
  