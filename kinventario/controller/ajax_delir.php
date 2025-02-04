<?php
 session_start();
 
 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	
	$set   = 	new ItemsController; 
	
	$bd	   =	 	new Db ;
	
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
  
 	 if (isset($_GET['codigo']))	{
	
    	 $id_asiento  = $_GET['codigo'];
		 $codigo      = trim($_GET['ref']);
	  	 
	 		
		// elimna el anexo
		 $sql = " delete from co_compras_f
		 		    where id_asiento =".$bd->sqlvalue_inyeccion($id_asiento, true).' and 
                          codretair  ='.$bd->sqlvalue_inyeccion($codigo, true);
	
 	  	$resultado = $bd->ejecutar($sql);
 	  
         
	    $obj->var->kaipi_cierre_pop();
   		  
   	  
     }
        
?>