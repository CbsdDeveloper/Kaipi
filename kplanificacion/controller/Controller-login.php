<?php

session_start( );

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

/*Creamos la instancia del objeto. Ya estamos conectados*/
$_SESSION['us'] = '';
$_SESSION['db'] = '';
$_SESSION['ac'] = '';

$bd	   =	new Db;
$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$sql11 = "SELECT RUC, NOMBRE FROM STEMPRESA";

$resultado1 = $bd->ejecutar($sql11);
$datos11     = $bd->obtener_array( $resultado1);

 $_SESSION['ruc_registro'] =  $datos11['RUC'];
 $_SESSION['razon'] 	    =  $datos11['NOMBRE'];
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
			 ;
			//---------------------------------------------variable------------------------------------
			if ($security == 'register'){
				
				$codigos = 'S'; // $_SESSION['captcha']
				
					if($codigos == 'S'){
						
								if ($pos === false) {
									$where='USUARIO ='.$bd->sqlvalue_inyeccion($user,true). ' and 	
													ACCESO='.$bd->sqlvalue_inyeccion($clave,true);
									
								} else {
									$where ='EMAIL='.$bd->sqlvalue_inyeccion($user,true). ' and 
													 ACCESO='.$bd->sqlvalue_inyeccion($clave,true);
								}
							
								$AResultado = $bd->query_array('STUSUARIOS',
																'USUARIO,EMAIL,NOMBRE ', 
																 $where
								);
  								
					   
 						         //-------------------------------------------------------------------------------------------------------------------------
								if (!empty($AResultado['USUARIO'])){
 						         	
									$_SESSION['login'] 		= $AResultado['USUARIO'];
									$_SESSION['email'] 		= $AResultado['EMAIL'];
									$_SESSION['usuario']  =   $AResultado['NOMBRE'];
			 						         	
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
 
  