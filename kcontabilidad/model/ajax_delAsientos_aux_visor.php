<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
    $obj   = 	new objects;
 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
 	     $id_asiento_aux  = $_GET['id'];
 
 	     $data = 'Registro eliminado ' .$id_asiento_aux;
 	     
 
 	     $estado          = $_GET['estado'];
 
        
			    	 if (trim($estado) == 'digitado'){    
			    	   
			    	   
			      		  $sql = 'delete from co_asiento_aux
			    				 WHERE id_asiento_aux ='.$bd->sqlvalue_inyeccion($id_asiento_aux, true);   
			      		  
			    	 	  $bd->ejecutar($sql);	
			    	 	  
			    	 } 
        }   
	 
        echo $data;
 	 
?>