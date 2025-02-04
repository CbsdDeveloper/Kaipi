<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 


    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
 	 if (isset($_GET['id_asiento']))	{
 	  
 	     $id_asiento   = $_GET['id_asiento'];
 	     $idprov       = trim($_GET['id']);
  	     $id_tramite   = $_GET['id_tramite'];
 	     
  
  	     
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
			    	 	  
		 
		  if ( $id_tramite > 0 ){
		      
		      $sql1 = 'update presupuesto.pre_tramite
                    set idprov='.$bd->sqlvalue_inyeccion(trim($idprov), true).' 
                  WHERE id_tramite ='.$bd->sqlvalue_inyeccion($id_tramite, true);
		      
		      $bd->ejecutar($sql1);	
		      
		    
		      
		  }
		  
		  //---------------------------------------------------------------------------
		  $secuencia = $bd->query_array('co_asiento_aux',
		      'count(*) as nn',
		      "cuenta like '21%' and haber >  0 and 
              id_asiento=".$bd->sqlvalue_inyeccion($id_asiento,true),0
		      );
			     
		  if ( $secuencia['nn'] > 0 ){
		      
		      $sql1 = " UPDATE co_asiento
							    SET 	modulo      =".$bd->sqlvalue_inyeccion('cxpagar', true)."
 							      WHERE id_asiento   =".$bd->sqlvalue_inyeccion($id_asiento, true);
		      
		      $bd->ejecutar($sql1);	
		  }
		  
		  
		  
        }   
	 
        echo $data;
 	 
?>