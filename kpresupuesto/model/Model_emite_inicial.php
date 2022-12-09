<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$anio       =  $_SESSION['anio'];


$accion          = $_GET['accion'];
$monto_inicial   = $_GET['monto_inicial_dato'];
$fpartida        = trim($_GET['fpartida']);
$orientador      = trim($_GET['orientador']);


$ftipo           = $_GET['ftipo'];
$detalle       = trim($_GET['detalle']);


 
$monto_inicial_dato = str_replace(',', '', $monto_inicial);


$periodo = $bd->query_array('presupuesto.pre_periodo',
                            'estado', 
                             'anio='.$bd->sqlvalue_inyeccion($anio,true)
    );
 
    if ( trim($periodo['estado']) == 'proforma' ){
        
        if ( $accion=='add'){

             
            if ( $ftipo == 'I'){
                    $sqlEditPre = "UPDATE presupuesto.pre_gestion
                                SET proforma =   ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                        inicial =  ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                        codificado =   ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                        detalle =   ".$bd->sqlvalue_inyeccion($detalle,true).",
                                    disponible  =".$bd->sqlvalue_inyeccion($monto_inicial_dato,true) ."
                            where partida = ".$bd->sqlvalue_inyeccion($fpartida,true). ' and 
                                    tipo = '.$bd->sqlvalue_inyeccion($ftipo,true). ' and 
                                    anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
             }else{

                $sqlEditPre = "UPDATE presupuesto.pre_gestion
                            SET proforma =   ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                    inicial =  ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                    codificado =   ".$bd->sqlvalue_inyeccion($monto_inicial_dato,true).",
                                    detalle =   ".$bd->sqlvalue_inyeccion($detalle,true).",
                                    orientador =   ".$bd->sqlvalue_inyeccion($orientador,true).",
                                disponible  =".$bd->sqlvalue_inyeccion($monto_inicial_dato,true) ."
                        where partida = ".$bd->sqlvalue_inyeccion($fpartida,true). ' and 
                                tipo = '.$bd->sqlvalue_inyeccion($ftipo,true). ' and 
                                anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
              }

            
            $bd->ejecutar($sqlEditPre);
            
            echo 'dato generado con exito '.$fpartida;
        }
        
        if ( $accion=='del'){
            
            $existec = $bd->query_array('presupuesto.pre_tramite_det',
                'count(*) as nn',
                'anio='.$bd->sqlvalue_inyeccion($anio,true).' and partida = '.$bd->sqlvalue_inyeccion($fpartida,true));
            
            
            $existep = $bd->query_array('presupuesto.pre_reforma_det',
                'count(*) as nn',
                'anio='.$bd->sqlvalue_inyeccion($anio,true).' and partida = '.$bd->sqlvalue_inyeccion($fpartida,true));
            
            
            $existef = $bd->query_array('co_asientod',
                'count(*) as nn',
                'anio='.$bd->sqlvalue_inyeccion($anio,true).' and partida = '.$bd->sqlvalue_inyeccion($fpartida,true));
         
        
            $sqlEditPre = "DELETE FROM  presupuesto.pre_gestion
                            where partida = ".$bd->sqlvalue_inyeccion($fpartida,true). ' and
                                     tipo = '.$bd->sqlvalue_inyeccion($ftipo,true). ' and
                                     anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
          
            $nvalido = $existec['nn'] + $existep['nn']  + $existef['nn'];
             
            if ( $nvalido > 0 ){
                
                echo 'Partida no se puede eliminar... datos ya generados!  '.$fpartida;
                
            }else{
               
                $bd->ejecutar($sqlEditPre);
                
                echo 'dato generado con exito '.$fpartida;
          
                
            }

        }
        
    }else {
        
        $sqlEditPre = "UPDATE presupuesto.pre_gestion
                           SET detalle =   ".$bd->sqlvalue_inyeccion($detalle,true)."
                    where partida = ".$bd->sqlvalue_inyeccion($fpartida,true). ' and
                            tipo = '.$bd->sqlvalue_inyeccion($ftipo,true). ' and
                             anio = '.$bd->sqlvalue_inyeccion($anio,true) ;
        
        $bd->ejecutar($sqlEditPre);
        
        echo 'dato generado con exito '.$fpartida;
        echo 'Presupuesto en estado no valido';
    }
     

   
   
?>
