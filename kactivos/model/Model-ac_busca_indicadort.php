<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
$bd	   = 	new Db ;

 


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$query	= '%' . strtoupper ( $_GET["query"]) .'%'  ;

 
$referencia = trim(strtoupper($_GET['referencia']));

 

 
          
    $sql = "SELECT  catalogo 
            FROM   activo.view_matriz_esigef
            WHERE  item like '8402%' and   catalogo like ".$bd->sqlvalue_inyeccion($query, true)." 
            order by detalle";
     
 

        $stmt = $bd->ejecutar($sql);
        
        $clase_esigef = array();
        
        while ($x=$bd->obtener_fila($stmt)){
            
            $cnombre =  trim($x['catalogo']);
            
            $clase_esigef[] =  $cnombre ;
            
        }
        
        $n = count($clase_esigef);
        
        if ( $n ==  0 ) {
            
            $clase_esigef[] =  'NO EXISTE' ;
            
            
        }
        
        
        echo json_encode($clase_esigef);
        



?>
 
  