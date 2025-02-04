<?php
session_start( );

require '../../kconfig/Db.class.php';   

require '../../kconfig/Obj.conf.php'; 

 
$bd	   = 	new Db ;

 


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$query	=   strtoupper ( $_GET["query"]) .'%'  ;

 
        $sql = "SELECT  nombre
        		  FROM   web_marca
        		  WHERE  nombre like ".$bd->sqlvalue_inyeccion($query, true)."
                  order by nombre";
        
         
        $marca  = array();
        
        $stmt = $bd->ejecutar($sql);
        
        while ($x=$bd->obtener_fila($stmt)){
            
            $cnombre =  trim($x['nombre']);
            
            $marca[] =  $cnombre ;
            
        }
        
        $n = count($marca);
        
        if ( $n ==  0 ) {
            
            $marca[] =  'NO EXISTE' ;
            
            
        }
        
        
        echo json_encode($marca);




?>
 
  