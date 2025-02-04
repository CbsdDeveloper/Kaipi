<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 	
  
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
		 $id_asientod = $_GET['id'];
		 
 	     $id_asiento = $_GET['id_asiento'];
 
          $sql = "SELECT *
    	            FROM co_asiento  
                    where id_asiento = ".$bd->sqlvalue_inyeccion($id_asiento ,true);
      	
         $resultado = $bd->ejecutar($sql);
         
      	 $datos1 = $bd->obtener_array( $resultado);
	  
         // parametros kte 
  	     $estado     = $datos1["estado"];
	  
			    	 if (trim($estado) == 'digitado'){    
			    	   
			    	      $sql = 'delete from co_asientod
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);   
			    	 	  
			               $bd->ejecutar($sql);
			    		  
			      		  $sql = 'delete from co_asiento_aux
			    				 WHERE id_asientod='.$bd->sqlvalue_inyeccion($id_asientod, true);   
			      		  
			    	 	  $bd->ejecutar($sql);		  
			    	 } 
        }   
	    
        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ELIMINADO !!!</b>';
        
        echo $result;
        
 	 
?>