<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT nombre, estado, indicaciones,id_medicina
				  FROM medico.me_medicina
				  where upper(nombre) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
  
 
  
  
    $resultado1 = $bd->ejecutar($sql);
    
    $x  = $bd->obtener_array( $resultado1);
    
    $prov = trim($x['id_medicina']);
 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=> trim($x['indicaciones']) 
                       )  
                    );
    
     
    
?>