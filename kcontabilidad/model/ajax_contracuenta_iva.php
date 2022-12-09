<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio_ejecuta = $_SESSION['anio'];


$cuenta = trim($_GET['cuenta']);

$x = $bd->query_array('co_plan_ctas',
                            'credito,partida_enlace', 
                            'tipo_cuenta='.$bd->sqlvalue_inyeccion('I',true).' and 
                            univel='.$bd->sqlvalue_inyeccion('S',true).' and
                            anio='.$bd->sqlvalue_inyeccion($anio_ejecuta,true).' and
                            cuenta='.$bd->sqlvalue_inyeccion(trim($cuenta),true),1
    
    );

 
 
    if ( $cuenta <> '-') {
    
        $sql1 = 'SELECT  cuenta, detalle_cuenta 
                    FROM presupuesto.view_enlace_conta_ingreso
                    where anio =  '.$bd->sqlvalue_inyeccion($anio_ejecuta,true) ." and 
                          tipo_cuenta = 'I' and 
                          grupo =  ".$bd->sqlvalue_inyeccion(trim($x['credito']),true)  .' 
                   group by cuenta, detalle_cuenta 
                    order by 2 asc';
 
            
        $stmt1 = $bd->ejecutar($sql1);
        
         
               echo '<option value="-"> [ No Aplica ] </option>';
        
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    echo '<option value="'.$fila['cuenta'].'">'.trim($fila['cuenta']).' '. trim($fila['detalle_cuenta']).'</option>';
                    
                }
        }
        else   {
            
    
            echo '<option value="-"> [ No Aplica ] </option>';
            
        }
      
 

?>
								
 
 