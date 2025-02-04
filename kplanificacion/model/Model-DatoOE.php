 <?php 
    session_start();  
    
    include ('../../kconfig/Db.class.php');   
 	include ('../../kconfig/Obj.conf.php'); 
	
 
	$bd	   =    new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    
  
 	 if (isset($_GET['id']))	{
 	  
 	     $idcodigo   			= $_GET['id'];
 	     
 	     $sql_nivel1 = "SELECT objetivoe, estado, aporte, ambito, sesion,creacion, sesionm, modificacion,idestrategia
 	                 FROM planificacion.pyestrategia
                     WHERE estado = 'S' AND nivel =".$bd->sqlvalue_inyeccion($idcodigo,true)." 
                order by objetivoe";
 	     
 	     $stmt_nivel1 = $bd->ejecutar($sql_nivel1);
 	     
 	     
 	     
 	     while ($AResultado=$bd->obtener_fila($stmt_nivel1)){
 	         
 	         $idestrategia = $AResultado['idestrategia'];
  	         
 	         $ViewVisorArbol .= '<h5> <a href="#" onClick="goToURLArbol('.  $idestrategia.')"><b>'.$AResultado['objetivoe'].'</b></a></h5>';
 	         $ViewVisorArbol .= '<span style="font-size: 13px">Ambito: '.$AResultado['ambito'].'<br>';
 	         $ViewVisorArbol .= 'Aporte: '.$AResultado['aporte'].' <br>';
 	         $ViewVisorArbol .= 'Creado:  '.$AResultado['sesion'].'<br>';
 	         $ViewVisorArbol .= 'Modificado:  '.$AResultado['sesionm'].'<br></span>';
 	         
 	     }
 	     
 	   
	    }
	    
	    echo $ViewVisorArbol;
        
 	 
?>


 