<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
  
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
 	     $id_asiento_aux  = $_GET['id'];
 
 	     $data = 'Actualizada Informacion ' .$id_asiento_aux;
 	      
 
          $sql = 'UPDATE presupuesto.pre_tramite_det
			        SET base = (certificado/ 1.12), 
                            iva = (certificado/ 1.12) *0.12 
                   WHERE id_tramite = '.$bd->sqlvalue_inyeccion($id_asiento_aux, true);   
			      		  
		  $bd->ejecutar($sql);	
			    	 	  
		  echo $data;
        }   
	 
      
 	 
?>