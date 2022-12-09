<?php  
 
    session_start();  
 
    require '../../kconfig/Db.class.php';   
    require '../../kconfig/Obj.conf.php';  
    
     
    $obj   = 	new objects;
  	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
    $registro      =  $_SESSION['ruc_registro'];

    $idasiento     = $_GET['id_asiento'] ;
    
    $anio       =  $_SESSION['anio'];
    
     
    $sql = ' SELECT a.id_asientod as id,  
                    a.cuenta as "Cuenta", 
                    b.detalle as " Detalle",
					coalesce(a.debe,0) as "Ingreso", 
                    coalesce(a.haber,0) as "Egreso", 
                    a.aux
 			FROM co_asientod a, co_plan_ctas b
			WHERE a.cuenta = b.cuenta and 	
				  a.registro = b.registro and 
                  b.tipo_cuenta= '.$bd->sqlvalue_inyeccion('B', true).' and 
                  b.anio= '.$bd->sqlvalue_inyeccion($anio, true).' and 
				  a.registro ='.$bd->sqlvalue_inyeccion(trim($registro), true).' and 
				  a.id_asiento='.$bd->sqlvalue_inyeccion($idasiento, true).' 
			order by a.id_asientod';
	
          $resultado	= $bd->ejecutar($sql);
          
		  $tipo 		= $bd->retorna_tipo();
 		 
		 $enlaceModal    ='myModalAux-myModalCostos';
		 
         $enlace    = '../model/ajax_delAsientosd';
        
         $variables = 'codigo='.$idasiento;
    	
         $obj->grid->KP_GRID_POP_asientos_te($resultado,$tipo,'id', $enlace,$enlaceModal,$variables,'S','','','del',950,580,''); 
     
         $div_mistareas = 'ok';
      
         echo $div_mistareas;
?> 

  