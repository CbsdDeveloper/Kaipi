<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
	
	$bd	   = new Db ;
	
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $id_concilia	=	$_GET["id_concilia"];
    $fecha= $_GET["fecha"];
    
 
    
    $Acon= $bd->query_array('co_concilia',
                                      'anio, mes,   estado, cuenta', 
                                      'id_concilia='.$bd->sqlvalue_inyeccion($id_concilia,true)
                                     );
    
    //----------------------------------------------------------------
    
    
    $ASaldos = $bd->query_array('view_diario_conta',
                'sum(debe) as debe, sum(haber) as haber, sum(debe) - sum(haber)  as saldo',
                    'cuenta   = '.$bd->sqlvalue_inyeccion(trim($Acon['cuenta']),true).' and
                     registro = '.$bd->sqlvalue_inyeccion($registro,true).' and
                     anio     = '.$bd->sqlvalue_inyeccion($Acon['anio'],true).' and
                     fecha <= '.$bd->sqlvalue_inyeccion($fecha,true)
        );
    
 
  
    
    
    $saldosPeriodo = $ASaldos["saldo"];
    
    $numerico = $saldosPeriodo;
    
    $saldobanco = (float)$numerico;
    
   
    echo $saldobanco;
    
?>
 
  