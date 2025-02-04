<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	

 
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id']))	{
 	  
 	     $id_asiento   = $_GET['id_asiento'];
 	     $idprov       = $_GET['id'];
 	     
 
 	     $AResultado = $bd->query_array('co_asiento_aux',       
 	                                          'sum(debe) as debe,sum(haber) as haber', 
 	                                          'idprov='.$bd->sqlvalue_inyeccion(trim($idprov),true). ' and 
                                               id_asiento='.$bd->sqlvalue_inyeccion($id_asiento,true)
 	         );
 	     
 	     $saldo = $AResultado['debe'] - $AResultado['haber'];
 	     
 	     $apagar = round(abs($saldo),2);
 	     
 
 	     $data = 'Actualizado ' .$id_asiento.' '.$idprov;
 
			    	   
 	     $sql = 'update co_asiento 
                    set idprov='.$bd->sqlvalue_inyeccion(trim($idprov), true).' ,
                        apagar='.$bd->sqlvalue_inyeccion(trim($apagar), true).'
                  WHERE id_asiento ='.$bd->sqlvalue_inyeccion($id_asiento, true);   
			      		  
		  $bd->ejecutar($sql);	
			    	 	  
			     
        }   
	 
        echo $data;
 	 
?>