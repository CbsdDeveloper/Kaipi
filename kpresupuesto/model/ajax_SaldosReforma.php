<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

  
require 'Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$id_reforma    = $_GET['id'] ;

$fecha    = $_GET['fecha'] ;

$f2       = date("Y-m-d",strtotime($fecha."- 1 days")); 


$saldos     = 	new saldo_presupuesto(  $obj,  $bd);
        
$anio       =  $_SESSION['anio'];

$sql = ' SELECT id_reforma_det as id,
                partida ,
               tipo
 			FROM presupuesto.view_reforma_detalle
			WHERE id_reforma ='.$bd->sqlvalue_inyeccion($id_reforma, true).'  
			order by id_reforma_det';

  
        
        $resultado	= $bd->ejecutar($sql);

        while ($y=$bd->obtener_fila($resultado)){
            
                 $partida = trim($y['partida']);

                 $id  = $y['id'];
             
      
                 if ( trim($y['tipo']) == 'I'){
                 
                 }else{
                    $disponible = $saldos->PresupuestoDisponible_partida($f2,$partida,'G' );

                 }
       
                 $sqlEditPre1 = "UPDATE presupuesto.pre_reforma_det
                 SET saldo  = ".$bd->sqlvalue_inyeccion($disponible,true)."
                   where id_reforma_det = ".$bd->sqlvalue_inyeccion($id,true) ;

                $bd->ejecutar($sqlEditPre1); 

            
        }
    
        
$div_mistareas = 'ok..'.$f2. $disponible.'<br>';

echo $div_mistareas;
?>
 