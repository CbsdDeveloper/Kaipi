<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = new Db ;
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 

   $id_asiento_aux =   $_GET['id_asiento_aux'];
   $pagado         =   trim($_GET['pagado']);


   $y               =   $bd->query_array('co_asiento_aux','id_asiento', 'id_asiento_aux='.$bd->sqlvalue_inyeccion( $id_asiento_aux,true)  );
   $id_asiento      =   $y['id_asiento'];

   $x = $bd->query_array('co_asiento','*', 'id_asiento='.$bd->sqlvalue_inyeccion( $id_asiento,true)  );
    
    
   $sql = "UPDATE co_asiento_aux
                  SET  pago = ". $bd->sqlvalue_inyeccion(trim( $pagado) ,true).", 
                       fecha= ". $bd->sqlvalue_inyeccion( $x['fecha'],true).",
                       detalle= ". $bd->sqlvalue_inyeccion(trim( $x['detalle'] ),true)."
                WHERE id_asiento_aux = ".$bd->sqlvalue_inyeccion( $id_asiento_aux,true);
    	
   $bd->ejecutar($sql);
    	
 
 
 echo 'Dato actualizado... Asiento '.  $id_asiento. '...  Estado pagado: '.    $pagado ;
    
?>
 
  