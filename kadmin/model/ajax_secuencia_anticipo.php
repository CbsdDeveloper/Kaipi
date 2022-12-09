<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	$bd	   = new Db ;
	
 
	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $id         = trim($_GET['id']);
 
    $Array      = $bd->query_array('co_anticipo','documento', 'id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true));
    $documento  = trim($Array['documento']) ;
    $anio       = date('Y');

    if ( trim($documento) == '00000-0000') {
 
        $Array = $bd->query_array('wk_config','modulo , carpetasub', 'tipo='.$bd->sqlvalue_inyeccion(79,true));
        
        $secuencia =  intval($Array['carpetasub']);
        $siglas    =  trim($Array['modulo']);
 
        $documento =   $siglas.'-'. str_pad($secuencia,6,"0",STR_PAD_LEFT) .'-'.$anio;

        $sql_update = "update wk_config set carpetasub=". $bd->sqlvalue_inyeccion(  $secuencia + 1 ,true)." where tipo=79";
         $bd->ejecutar($sql_update);


        $sql_update = "update co_anticipo set documento=". $bd->sqlvalue_inyeccion(  $documento  ,true).'where id_anticipo='.$bd->sqlvalue_inyeccion(  $id ,true);
        $bd->ejecutar($sql_update);


    }  
   
       
    
    
    echo json_encode( array("a"=>trim($documento)   ) );
    

  
    
?>