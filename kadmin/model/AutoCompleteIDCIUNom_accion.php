<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
  
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  

    $sql = "SELECT   idprov, razon,  unidad ,  regimen,  cargo, programa,sueldo
				  FROM view_nomina_rol
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
  
  
  
    $resultado1 = $bd->ejecutar($sql);
    
    $x  = $bd->obtener_array( $resultado1);
    
    $prov = trim($x['idprov']);
 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=> trim($x['unidad']) ,
                            "c"=> trim($x['cargo']) ,
                            "d"=> $x['sueldo']  
                       )  
                    );
    
     
    
?>