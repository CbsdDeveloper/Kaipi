<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 
    
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
      
    $accion      =  $_GET['accion'];
    $idtramite   =  $_GET['idtramite'];
    
    if ($accion == 'visor'){
        
        
        $sql = "SELECT   fecha,fcertifica, fcompromiso,estado
				  FROM presupuesto.pre_tramite
				  where id_tramite =".$bd->sqlvalue_inyeccion($idtramite,true) ;
        
        
        $resultado1 = $bd->ejecutar($sql);
        
        $dataProv  = $bd->obtener_array( $resultado1);
 
        
        
        echo json_encode( 
                          array(
                                "a"=> $dataProv['fecha'], 
                                "b"=> $dataProv['fcertifica'],
                                "c"=> $dataProv['fcompromiso'] ,
                                "d"=> trim($dataProv['estado']) 
                          ) );
        
        
    }
    
    if ($accion == 'edit'){
        
        $fecha   =  $_GET['fecha'];
        $fechac   =  $_GET['fechac'];
        $fechacc   =  $_GET['fechacc'];
        $festado   =  trim($_GET['festado']);
        
        if ( trim($festado) <> '6' ){
            
            // $sql = 'update presupuesto.pre_tramite
            //            set fecha ='.$bd->sqlvalue_inyeccion($fecha,true).',
            //                estado='.$bd->sqlvalue_inyeccion($festado,true).',
            //                fcertifica='.$bd->sqlvalue_inyeccion($fechac,true).',
            //                fcompromiso='.$bd->sqlvalue_inyeccion($fechacc,true).'
            //          WHERE id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true);
            
                     $sql = 'update presupuesto.pre_tramite
                       set fecha ='.$bd->sqlvalue_inyeccion($fecha,true).',
                           fcertifica='.$bd->sqlvalue_inyeccion($fechac,true).',
                           fcompromiso='.$bd->sqlvalue_inyeccion($fechacc,true).'
                     WHERE id_tramite='.$bd->sqlvalue_inyeccion($idtramite,true);
            
            $bd->ejecutar($sql);	
             
            $resultado = 'Dato actualizado '. $idtramite;
            
            echo $resultado;
            
        }else{
            
            $resultado = 'Dato No se puede actualizar '. $idtramite;
             echo $resultado;
        }
    }
        
    
  
    
?>