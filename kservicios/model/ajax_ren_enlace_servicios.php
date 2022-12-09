<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
$id    = $_GET['id'] ;
$parte = trim($_GET['parte'] );



        $x = $bd->query_array('co_asiento',   // TABLA
            'estado',                        // CAMPOS
            'id_asiento='.$bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        
        if (trim($x['estado']) == 'aprobado'  ){    
            
        }else {  
            
            $sql = "UPDATE co_asientod_manual
        							    SET 	contabilizado  =".$bd->sqlvalue_inyeccion(0, true)."
        							      WHERE parte=".$bd->sqlvalue_inyeccion(trim($parte),true) ;
                                               
           $bd->ejecutar($sql);
           
           
           $sql = "UPDATE co_asiento
        							    SET 	estado  =".$bd->sqlvalue_inyeccion('anulado', true)."
        							      WHERE id_asiento=".$bd->sqlvalue_inyeccion($id,true) ;
           
           $bd->ejecutar($sql);
                                               
        }
         
        
        
       
        
         
        
        $div_mistareas = ' ';
        
        echo $div_mistareas;
?>