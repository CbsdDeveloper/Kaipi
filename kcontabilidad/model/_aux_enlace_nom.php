<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 

   $idasientobas       =   $_GET['idasientobas'];
   $partidabas         =   trim($_GET['partidabas']);

 
    
   $sql = "UPDATE co_asientod
                  SET  partida = ". $bd->sqlvalue_inyeccion(trim( $partidabas) ,true)."
                WHERE id_asientod = ".$bd->sqlvalue_inyeccion( $idasientobas,true);
    	
   $bd->ejecutar($sql);
    	
 
 
   echo 'Dato actualizado... Asiento '.  $partidabas  ;
    
?>
 
  