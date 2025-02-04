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

$validacion = 0;

if (isset($_POST['s'])){
	
	$security = $_POST['s'];
	
	$user 		= @$_POST['username'];
	
	$password 	= @$_POST['password'];
	
	$codigos 	= @$_POST['codigos'];
	
	_empresaDatos($bd);
	
 	if ($security == 'register'){
			 if($codigos == $_SESSION['captcha']){
			 $validacion =  _usuario($user,$password,$bd,$obj);
			 }else{
			 $validacion = 0;
			 }
	 }
	 
}
//-------------
if ($validacion == 0){
	 	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=../view/login">';
 }
else{

 	 echo '<meta HTTP-EQUIV="REFRESH" content="0; url=kadmin/view/View-panel">';
}

//----------------------------------------------------------------------------------------------
// usuarios del sistema
//----------------------------------------------------------------------------------------------
function _usuario($user,$password,$bd,$obj){
	
	$clave = $obj->var->_codifica($password); //Creamos una query sencilla
	
	$pos = strpos($user, '@');
	
	$datos = _sql($pos,$user,$clave,$bd,$obj);
	
	$validacionUser = _validacion($datos);
	
	return $validacionUser;
}
//----------------------------------------------------------------------------------------------
// sql busqueda
//----------------------------------------------------------------------------------------------
function _sql($pos,$user,$clave,$bd,$obj){
	
	if ($pos === false) {
		
		$sql='SELECT login,email,rol,url,idusuario
			    					  FROM par_usuario
			    					 where login='.$bd->sqlvalue_inyeccion($user,true). ' and
			    					 	   clave='.$bd->sqlvalue_inyeccion($clave,true);
		
	} else {
		
		$sql='SELECT login,email,rol,url,idusuario
			    					   FROM par_usuario
			    					 where email='.$bd->sqlvalue_inyeccion($user,true). ' and
			    					       clave='.$bd->sqlvalue_inyeccion($clave,true);
	}
	
	$stmt = $bd->ejecutar($sql);
	
	$datos=$bd->Arrayfila($stmt);
	
	return $datos;
	
}

//----------------------------------------------------------------------------------------------
// sql busqueda
//----------------------------------------------------------------------------------------------
function _validacion($datos){
	
	if (!empty($datos)){
		$_SESSION['login'] = $datos['login'];
		$_SESSION['email'] = $datos['email'];
		$_SESSION['rol']   = $datos['rol'];
		$_SESSION['foto']  = $datos['url'];
		$_SESSION['usuario']  = $datos['idusuario'];
		return  1;
	}
	else
	{
		return  0;
	}
	
}
//----------------------------------------------------------------------------------------------
// sql busqueda
//----------------------------------------------------------------------------------------------
function _empresaDatos($bd){
	
	//Realizamos un bucle para ir obteniendo los resultados
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
	
}


?>
 
  