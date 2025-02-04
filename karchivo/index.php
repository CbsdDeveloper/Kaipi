<?php 
	session_start( );  

  	if (empty($_SESSION['usuario']))  {
		
		header('Location: ../kadmin/');
		
    }else{
		
		header('Location: view/inicio');
		
	}
	
	
?>
 