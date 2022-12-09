<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
	$anio  = $_SESSION['anio'];
	
 
	
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
  
    
    $sql = "SELECT   idprov, razon,   id_departamento, id_cargo,   regimen, cargo,  programa,sueldo
				  FROM view_nomina_rol
				  where upper(razon) =".$bd->sqlvalue_inyeccion($txtcodigo,true) ;
  
  
  
    $resultado1 = $bd->ejecutar($sql);
    
    $x  = $bd->obtener_array( $resultado1);
    
    $prov = trim($x['idprov']);
 
    
    echo json_encode( array("a"=>$prov, 
                            "b"=> trim($x['regimen']) ,
                            "c"=> trim($x['programa']) ,
                            "d"=> $x['id_departamento'] ,
                            "e"=> $x['id_cargo'] ,
                            "f"=> $x['sueldo'] 
                       )  
                    );
    
     
    
?>