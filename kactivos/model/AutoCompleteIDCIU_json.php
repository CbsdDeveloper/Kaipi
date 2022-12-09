<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $txtcodigo = strtoupper($_GET['itemVariable']);
    
    
    $sql1 = 'SELECT idprov as codigo,   razon as nombre, id_departamento,idciudad
                FROM view_nomina_rol
                where  upper(razon) = '.$bd->sqlvalue_inyeccion($txtcodigo,true);
 
    
 
    
    $resultado1 = $bd->ejecutar($sql1);
    
    $dataProv  = $bd->obtener_array( $resultado1);
 
    
    echo json_encode( array(
                    "a"=>trim($dataProv['codigo']),
                    "b"=> trim($dataProv['id_departamento']) , 
                    "c"=> $dataProv['idciudad']
             )
        );
    
 
     
    
?>
