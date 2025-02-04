<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $anio      =  $_GET['fanio'];
     
    
    $x = $bd->query_array('presupuesto.pre_gestion','sum(codificado) as ingreso', 
                          'anio='.$bd->sqlvalue_inyeccion($anio,true). ' and tipo = '.$bd->sqlvalue_inyeccion('I',true)
                         );
    
    $y = $bd->query_array('presupuesto.pre_gestion','sum(codificado) as gasto',
        'anio='.$bd->sqlvalue_inyeccion($anio,true). ' and tipo = '.$bd->sqlvalue_inyeccion('G',true)
        );
    
   
    $ingreso = number_format($x['ingreso'],2,",",".");
    $gasto   = number_format($y['gasto'],2,",",".");
    
    $saldo = $x['ingreso'] - $y['gasto'];
    
    $error = '';
    
    if ($saldo <> 0	){
        $error = '<br> Error diferencia = '.$saldo;
    }
    
    $resultado = 'INGRESO = GASTO <br>'. $ingreso. ' = '. $gasto.$error ;
    
    
     
    echo $resultado;
    
?>