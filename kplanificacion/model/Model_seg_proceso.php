<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$proceso           = $_GET['proceso'];   
$Q_IDPERIODO       = $_GET['Q_IDPERIODO'];

$sesion 	 =  trim($_SESSION['email']);

$datos =  $bd-> __user($sesion);

$idpartamento = $datos['id_departamento'];

$sql = "SELECT a.nombre, a.idtarea_seg, a.idtarea_segcom,a.sesion ,a.creacion, a.secuencia,
	           b.seg_tarea_seg ,b.seg_proceso,b.seg_estado ,b.seg_fecha,  b.seg_secuencia , b.avance , b.comentario,
	           c.tarea ,c.avance as avance_tarea,
	           c.nombre_funcionario ,c.anio ,a.proceso_tarea,b.idtarea
FROM planificacion.view_tarea_proceso a, 
	 planificacion.sitarea_seg b,
	 planificacion.view_tarea_poa c 
where a.iddepartamento  = ".$bd->sqlvalue_inyeccion(trim($idpartamento), true)." and 
	  a.cumplio = 'N' and 
	  c.anio = ".$bd->sqlvalue_inyeccion($Q_IDPERIODO, true)." and
	  b.seg_proceso= ".$bd->sqlvalue_inyeccion(trim($proceso), true)." and
	  b.idtarea_seg = a.idtarea_seg and 
	  b.idtarea = c.idtarea
    order by a.idtarea_seg";
 
 

$resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO


echo '<h4>LISTA DE ACTIVIDADES EN EJECUCIÓN <br><b>'.$datos['unidad'].'</b></h4>';

echo '<table class="actividad">
              <tr>
                     <td width="10%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Documento</td>               
                    <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Solicita</td>
                  <td width="30%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Actividad/Tarea</td>
                  <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Justificacion</td>
                  <td width="10%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
                  <td width="10%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Acciones</td>
            </tr>';

 

while ($z=$bd->obtener_fila($resultado)){
    
    
    $nombre                    = trim($z['nombre_funcionario']);
    $proceso_tarea             = trim($z['tarea']);
    $tarea_com                 = trim($z['seg_tarea_seg']);
    $completo                  = trim($z['seg_secuencia']);
    
    $proceso =   trim($z['proceso_tarea']);
    
    $fecha                     = $z['seg_fecha'];
    $idtarea_seg               = $z['idtarea_seg'];
    
    $idtarea_segcom =  $z['idtarea_segcom'];
    
     
    $idtarea = $z['idtarea'];
     
    
    if ( empty($nombre)){
        $nombre = '<b>UNIDAD</b>';
    }
    
    $ajaxCateg = ' data-toggle="modal" data-target="#myModal" onClick="VerTarea('."'".$idtarea."'".')" ';
    
    $ajaxPic = ' data-toggle="modal" data-target="#myModalActualiza" onClick="SiguientePaso('.$idtarea.','.$idtarea_seg.','.$idtarea_segcom.')" ';
    
    
    $boton1 =  '<a class="btn btn-xs btn-warning" href="#" '.$ajaxCateg.' title= "Ver Actividad/Tarea">
                           <i class="glyphicon glyphicon-cog"></i> 
                            </a> '  ;
    
    $boton2 =  '<a class="btn btn-xs btn-default" href="#" '.$ajaxPic.' title= "Agregar documentos complementarios">
                            <i class="glyphicon glyphicon-download-alt"></i> 
                            </a> '  ;
    
    $boton3 =  '<a class="btn btn-xs btn-info" href="#" '.$ajaxPic.' title= "Visualizar documentos generdos">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            </a> '  ;
    
    $boton4 =  '<a class="btn btn-xs btn-danger" href="#" '.$ajaxPic.' title= "Actualizar y Enviar Siguiente Proceso">
                            <i class="glyphicon glyphicon-ok"></i>
                            </a> '  ;
    
    echo '<tr>
              <td  style="padding: 5px;"><b>'.  $completo.'</b></td>
              <td  style="padding: 5px;">'.$nombre.'</td>
              <td  style="padding: 5px;">'.$proceso_tarea.'</td>
              <td  style="padding: 5px;">'.$tarea_com.'</td>
              <td  style="padding: 5px;">'.$fecha.'</td>
              <td  style="padding: 5px;">'.$boton1.$boton2.$boton3.$boton4.'</td>';
    
    
    echo '</tr>';
    
}


echo '</table>';

echo '<p>&nbsp;</p><p><h5>Evento: <b>'.$proceso.' </b></h5></p>';


 
?>


  