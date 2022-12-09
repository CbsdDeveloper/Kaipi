<?php
		
 		session_start( );  
 		
 		$enlace = $_SESSION['enlace'];
 		
 		$_SESSION['us'] = '';
		$_SESSION['ac'] = '';
		$_SESSION['usuario'] = null;
		
	//	$enlace = 'https://www.g-kaipi.cloud/EP-Const';
		
	//		$enlace = 'http://192.168.1.29/Gkaipi/';

	    $enlace = '../../';
	
     	session_destroy();
     
//		$parametros_cookies = session_get_cookie_params(); 

//		setcookie(session_name(),0,1,$parametros_cookies["path"]);
		
		header('Location: '.$enlace); //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=kadmin/panel">';

?>
 