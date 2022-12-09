<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);



$cuenta = $_GET['cuenta'];
 
$id_asiento = $_GET['id_asiento'];
 
    if ( $cuenta <> '-') {
    
   /*     $sql1 = 'SELECT  partida,detalle_partida as detalle 
                    FROM presupuesto.view_enlace_conta_ingreso
                    where  anio =  '.$bd->sqlvalue_inyeccion($anio,true) .' and 
                           cuenta = '.$bd->sqlvalue_inyeccion(trim($cuenta),true) .' order by 2 asc';
        
        */
        
        $sql1 = 'select partida  , partida  as detalle 
                    FROM co_asientod 
                    where id_asiento =  '.$bd->sqlvalue_inyeccion(trim($id_asiento),true) .' 
                    group by partida order by 2 asc';
                            
        
        $stmt1 = $bd->ejecutar($sql1);
        

            
               echo '<option value="-"> [ No Aplica ] </option>';
        
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    echo '<option value="'.$fila['partida'].'">'.trim($fila['partida']).'</option>';
                    
                }
        }
        else   {
            
    
            echo '<option value="-"> [ No Aplica ] </option>';
            
        }
      
 

?>
								
 
 