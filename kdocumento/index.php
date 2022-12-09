<?php 
	session_start( );  
	
 

  	if (empty($_SESSION['usuario']))  {
		header('Location: ../kadmin/view/login');
    }else{
		header('Location: view/inicio');
	}
	
	
?>

 