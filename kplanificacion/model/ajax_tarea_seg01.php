<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 $bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$tarea        = $_GET['idtarea'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

 
 

    $sql = "select  idtarea_seg,seg_fecha,seg_secuencia,seg_estado_proceso,sesion_ultima, fecha_ultima,
                    seg_estado,seg_tarea_seg, seg_solicitado,coalesce(avance,0) as avance 
            from planificacion.sitarea_seg
            where idtarea = ".$bd->sqlvalue_inyeccion($tarea, true).
            " order by  idtarea_seg desc";
  
$stmt1  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

  
 
$i = 1;

while ($fila=$bd->obtener_fila($stmt1)){
    
    
    $detalle            =   strtolower(trim($fila['seg_tarea_seg']));
    $seg_estado_proceso =   trim($fila['seg_estado_proceso']) ;

    $idtarea_seg         = $fila['idtarea_seg'];

    $seg_estado_proceso =   trim($fila['seg_estado_proceso']) ;
    $seg_estado         =   trim($fila['seg_estado']) ;
    $seg_secuencia      =   trim($fila['seg_secuencia']) ;

    $sesion_ultima     =   trim($fila['sesion_ultima']) ;
    $fecha_ultima      =   trim($fila['fecha_ultima']) ;
 
    $avance            =    '<b>'.$fila['avance'].' %'.'</b>' ;

    $seg_solicitado  = '';

    if ( $fila['seg_solicitado'] > 0  ){
         $seg_solicitado   =  '<b>$. '.$fila['seg_solicitado'].'</b>' ;
    }
    
    $imagen= 'p'.$i.'.png';
    
    echo '  <div class="media">
    <div class="media-left">
      <img src="../../kimages/'. $imagen.'" class="media-object">
    </div>
    <div class="media-body">
      <h4 class="media-heading">'.$seg_estado_proceso .' <small><i> Solicitado '.$fila['seg_fecha'].'</i></small></h4>
      <p>'.$detalle.'<br>'.$seg_secuencia.' / '.$seg_estado.'<br>'. $sesion_ultima  .' / '. $fecha_ultima.'<br>'. $seg_solicitado.'<br>'. $avance.'</p>
       
            <div class="btn-group btn-group-sm">
                   <button type="button"  onClick="VerAvance('.$tarea.','.$idtarea_seg .')" class="btn btn-warning">Seguimiento Actividades</button>
                   <button type="button"  onClick="VerPoa('.$tarea.','.$idtarea_seg.",'".$seg_estado."'" .')" class="btn btn-success">Certificación PAPP-POA</button>
                   <button type="button" class="btn btn-info">Certificación PAC</button>
                   <button type="button" class="btn btn-danger">Anular Requerimiento</button> 
             </div>
  </div>
</div>
<hr>';
  
$i++;
    
}


?>