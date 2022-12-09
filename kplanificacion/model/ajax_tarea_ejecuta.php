<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
 
     $idtarea1        = $_POST['idtarea1'];  
     $idtarea_segcom  = $_POST['idtarea_segcom'];
    
    $secuencia_next  = $_POST['secuencia_next'];
    $idtarea_segcom_next  = $_POST['idtarea_segcom_next'];
    
    $comentario_dato = trim($_POST['comentario_dato']);  

   
     
    $sesion 	 =  trim($_SESSION['email']);
    $hoy 	     =  date('Y-m-d');
 
  
    
    $valida_texto = strlen($comentario_dato);
    
    if ( $valida_texto  > 5  ){
        
            $sqlE = "UPDATE planificacion.sitarea_seg_com
                            SET     cumplio=".$bd->sqlvalue_inyeccion('S', true)." ,
                                    tarea_com=".$bd->sqlvalue_inyeccion($comentario_dato, true)." ,
                                    sesion=".$bd->sqlvalue_inyeccion($sesion, true)." ,
                                    creacion=".$bd->sqlvalue_inyeccion($hoy, true)." 
                            WHERE idtarea_segcom=".$bd->sqlvalue_inyeccion($idtarea_segcom, true);
            
            $bd->ejecutar($sqlE);
        
            
            
            $sqlE = "UPDATE planificacion.sitarea_seg_com
                            SET     cumplio=".$bd->sqlvalue_inyeccion('N', true)."  
                            WHERE idtarea_segcom=".$bd->sqlvalue_inyeccion($idtarea_segcom_next, true). ' and 
                                  secuencia=' .$bd->sqlvalue_inyeccion($secuencia_next, true);
            
            $bd->ejecutar($sqlE);
            
            actualiza_tareas($bd,$idtarea1 );
            
            echo ' <h4>INFORMACION ENVIADA CON EXITO... VERIFIQUE LA INFORMACION DE LA UNIDAD</h4>';
         
    }
//------------------------------------    
  
    function actualiza_tareas($bd,$idtarea ){
        
        
        //---------- AVANCE DE TAREA
        $datos_avance = $bd->query_array('planificacion.sitarea_seg',
            'sum(avance) as avance,count(*) as subtareas',
            'idtarea='.$bd->sqlvalue_inyeccion($idtarea,true). " and seg_estado = 'ejecucion' "
            );
        
        $avance_geneeral = $datos_avance['avance'] / $datos_avance['subtareas'] ;
        
        $sql = "UPDATE planificacion.sitarea
               SET     avance=".$bd->sqlvalue_inyeccion( $avance_geneeral, true)."
               WHERE idtarea=".$bd->sqlvalue_inyeccion($idtarea, true);
        
        $bd->ejecutar($sql);
        
        
        //--------------------- avance actividad
        $datos_actividad = $bd->query_array('planificacion.sitarea',
            'idactividad',
            'idtarea='.$bd->sqlvalue_inyeccion($idtarea,true)
            );
        
        $idactividad =  $datos_actividad['idactividad'];
        
        
        $datos_ejecuta = $bd->query_array('planificacion.sitarea',
            'sum(coalesce(avance,0)) as avance, count(*) tareas',
            'idactividad='.$bd->sqlvalue_inyeccion($idactividad,true)
            );
        
        $avance_actividad = $datos_ejecuta['avance'] / $datos_ejecuta['tareas'];
        
        
        
        $sql = "UPDATE planificacion.siactividad
  SET     avance=".$bd->sqlvalue_inyeccion( $avance_actividad, true)."
  WHERE idactividad=".$bd->sqlvalue_inyeccion($idactividad, true);
        
        $bd->ejecutar($sql);
        
        
    }
 
?> 