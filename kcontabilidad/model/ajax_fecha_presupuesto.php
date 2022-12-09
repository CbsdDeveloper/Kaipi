<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $accion      =  $_GET['accion'];
    $idtramite   =  $_GET['idtramite'];


    
    if ($accion == 'visor'){
        
          
        $dataProv = $bd->query_array('presupuesto.pre_tramite',   // TABLA
        '*',                        // CAMPOS
        "id_tramite=".$bd->sqlvalue_inyeccion($idtramite,true) // CONDICION
        );


        //------------------------------
        
        $xx = $bd->query_array('co_asiento',   // TABLA
        '*',                        // CAMPOS
        "estado = 'aprobado' and 
        id_tramite=".$bd->sqlvalue_inyeccion($idtramite,true) // CONDICION
        );

 


        echo json_encode( 
                          array(
                                "a"=> $dataProv['fecha'], 
                                "b"=> $dataProv['fcertifica'],
                                "c"=> $dataProv['fcompromiso'] ,
                                "d"=> trim($dataProv['estado']) ,
                                "e"=> trim($xx['fecha']) ,
                                "f"=> trim($xx['id_asiento']) ,
                          ) );
        
        
    }
    
    if ($accion == 'edit'){
        
        $fecha   =  $_GET['fecha'];
        $fechac   =  $_GET['fechac'];
        $fechacc   =  $_GET['fechacc'];
        $festado   =  trim($_GET['festado']);

        $fechacd   =  $_GET['fechacd'];
        $idasiento   =  $_GET['idasiento'];
          
            $sql = 'update presupuesto.pre_tramite
                       set fecha ='.$bd->sqlvalue_inyeccion($fecha,true).',
                           estado='.$bd->sqlvalue_inyeccion($festado,true).',
                           fcertifica='.$bd->sqlvalue_inyeccion($fechac,true).',
                           fdevenga='.$bd->sqlvalue_inyeccion($fechacd,true).',
                           fcompromiso='.$bd->sqlvalue_inyeccion($fechacc,true).'
                     WHERE id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true);
            
            $bd->ejecutar($sql);	
             
            

            $resultado = 'Dato actualizado '. $idtramite;


            if ( $idasiento > 0  ){

                $sql = 'update co_asiento
                          set fecha ='.$bd->sqlvalue_inyeccion($fecha,true).'
                        WHERE id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true). ' and 
                              id_asiento='.$bd->sqlvalue_inyeccion($idasiento,true);
     
               $bd->ejecutar($sql);

            }
            
            echo $resultado;
            
       
    }
        
    
  
    
?>