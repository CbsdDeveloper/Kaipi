<?php 

session_start( );  
   	
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    
    $idtarea        = $_POST['seg_tarea1'];  
    $recurso        = trim($_POST['modulo']);  

    $seg_tarease1   = trim($_POST['seg_tarease1']);  
    $seg_comentario = trim($_POST['seg_comentario']);  
    $enlace_pac     = trim($_POST['enlace_pac']);  
    $modulo         = trim($_POST['modulo']);  
     
    $sesion 	 =  trim($_SESSION['email']);
    $hoy 	     =  date('Y-m-d');
 
  

    $datos = $bd->query_array('planificacion.sitarea_seg',
    'seg_solicitado, seg_estado,seg_secuencia,seg_tarea_seg,seg_proceso,seg_estado_proceso', 
    'idtarea_seg='.$bd->sqlvalue_inyeccion($seg_tarease1,true));

    $resultado = 'NO SE PUDO GENERAR LA TRANSACCION...('.$idtarea.') '.'('. $recurso.') '.$datos['seg_estado'];

    if ( $idtarea > 0 ){
                                           

           if ( trim($datos['seg_estado']) == 'solicitado')       {                       
        

            $datos_modulo = $bd->query_array('planificacion.proceso',
            'proceso,valor,secuencia', 
            'tipo='.$bd->sqlvalue_inyeccion($modulo,true). " and secuencia = '01'"
            );

            $seg_estado_proceso = $datos_modulo['proceso'];
            $avance             = $datos_modulo['valor'];
            $monto_solicita     = $datos['seg_solicitado'] ;

                $sqlE = "UPDATE planificacion.sitarea_seg
                        SET     seg_estado=".$bd->sqlvalue_inyeccion('ejecucion', true)." ,
                                comentario=".$bd->sqlvalue_inyeccion($seg_comentario, true)." ,
                                seg_estado_proceso=".$bd->sqlvalue_inyeccion($seg_estado_proceso, true)." ,
                                sesion_ultima=".$bd->sqlvalue_inyeccion($sesion, true)." ,
                                avance=".$bd->sqlvalue_inyeccion($avance, true)." ,
                                fecha_ultima=".$bd->sqlvalue_inyeccion($hoy, true)." 
                        WHERE idtarea_seg=".$bd->sqlvalue_inyeccion($seg_tarease1, true);
                
                $bd->ejecutar($sqlE);

              

                Generar_proceso( $bd,$idtarea,$seg_tarease1,$modulo,$seg_comentario);
 
                // actualiza saldos a la tarea
                if (  $monto_solicita > 0 )  {   

                     $datos_saldo = $bd->query_array('planificacion.sitarea_seg',
                                        'sum(coalesce(seg_solicitado,0)) as pedido', 
                                        'idtarea='.$bd->sqlvalue_inyeccion($idtarea,true). " and seg_estado = 'ejecucion' "
                                      );

                      $certificacion = $datos_saldo['pedido'];                

                      $sql = "UPDATE planificacion.sitarea
                                      SET     certificacion=".$bd->sqlvalue_inyeccion( $certificacion, true)." ,
                                              disponible=codificado-".$bd->sqlvalue_inyeccion($certificacion, true) ."
                                      WHERE idtarea=".$bd->sqlvalue_inyeccion($idtarea, true);
                              
                        $bd->ejecutar($sql);                  

                }

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

                
              $resultado = 'INFORMACION ACTUALIZADA CON EXITO...('.$idtarea.') '.'('. $recurso.')';

              Actualiza_tarea_actividad( $bd,$idtarea);

         }
          
         echo $resultado;

    }

 /*
 genera el recorriddo del proceso...
 */   
  function Generar_proceso( $bd,$idtarea,$seg_tarease1,$modulo,$comentario){

    $sql = "select  *
            from planificacion.proceso
            where tipo = ".$bd->sqlvalue_inyeccion($modulo, true). " and estado = 'S'  
            order by secuencia";

$stmt1  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
 

$tabla = 'planificacion.sitarea_seg_com';
$secuencia = 'planificacion.sitarea_seg_com_idtarea_segcom_seq';

     
$sesion 	 =  trim($_SESSION['email']);
$hoy 	     =  date('Y-m-d');

 
$i = 1 ;

    while ($fila=$bd->obtener_fila($stmt1)){

        if ( $i == 1){
            $cumplio= 'S';
            $sesion 	 =  trim($_SESSION['email']);
            $hoy 	     =  date('Y-m-d');
            $tarea_com = $comentario;
        }else    {
            $cumplio= 'N';
            $sesion 	 =  '@';
            $hoy 	     =  date('Y-m-d');
            $tarea_com   = 'Pendiente' ;
        }

        $proceso_tarea = trim($fila['proceso']);
        $iddepartamento = trim($fila['id_departamento']);
        $secuencia = trim($fila['secuencia']);

        $ATabla = array(
            array( campo => 'idtarea_segcom',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'idtarea_seg',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $seg_tarease1, key => 'N'),
            array( campo => 'tarea_com',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $tarea_com, key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>  $sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
            array( campo => 'cumplio',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $cumplio, key => 'N'),
            array( campo => 'idtarea',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $idtarea, key => 'N'),
            array( campo => 'proceso_tarea',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $proceso_tarea, key => 'N'),
            array( campo => 'iddepartamento',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor =>  $iddepartamento, key => 'N') ,
            array( campo => 'secuencia',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>  $secuencia, key => 'N') 
        );
        

        $bd->_InsertSQL($tabla,$ATabla, $secuencia  );

        $i++;

    }

  }
  //---------
  function Actualiza_tarea_actividad( $bd,$idtarea){


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