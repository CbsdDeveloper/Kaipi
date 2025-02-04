<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$seg_tarease1       = $_GET['seg_tarease1'];   // VARIABLE DE ENTRADA CODIGO DE BITACORA

 

    $sql = "SELECT idtarea_segcom, idtarea_seg, idtarea, secuencia, tarea_com, sesion, 
                   creacion, cumplio, proceso_tarea, iddepartamento, nombre ,completo
            FROM planificacion.view_tarea_proceso
            where idtarea_seg= ".$bd->sqlvalue_inyeccion($seg_tarease1, true).
            "order by secuencia";

 
  
    $resultado  = $bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO

     
    echo '<table class="actividad">
              <tr>
                  <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Unidad</td>
                  <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Evento</td>
                  <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Observacion/Novedad</td>
                  <td width="20%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable</td>
                  <td width="10%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
                  <td width="10%" style="padding: 5px" valign="top"  bgcolor="#A5CAE1">Cumple</td>
            </tr>';

    while ($z=$bd->obtener_fila($resultado)){
        
        
        $nombre                    = trim($z['nombre']);
        $proceso_tarea             = trim($z['proceso_tarea']);
        $tarea_com                 = trim($z['tarea_com']);
        $completo                  = trim($z['completo']);
        
        $fecha                     = $z['creacion'];
        
        $imagen = ' <img src="../../kimages/m_none.png">';
        
          
         
        if (trim($z['cumplio']) == 'N'){
            $imagen = ' <img src="../../kimages/m_rojo.png">';
        }
        if (trim($z['cumplio']) == 'S'){
            $imagen = ' <img src="../../kimages/m_verde.png">';
        }
        
        if (  $tarea_com == 'Pendiente'){
            $tarea_com = ' ';
            $fecha     = ' ';
        }
    
          
        if ( empty($nombre)){
            $nombre = '<b>UNIDAD</b>';
        }
        
        echo '<tr>
              <td  style="padding: 5px;">'.$nombre.'</td>
              <td  style="padding: 5px;">'.$proceso_tarea.'</td>
              <td  style="padding: 5px;">'.$tarea_com.'</td>
              <td  style="padding: 5px;">'.$completo.'</td>
              <td  style="padding: 5px;">'.  $fecha.'</td>
              <td  style="padding: 5px;">'.$imagen.'</td>';
        
        
        echo '</tr>';
       
    }
    
   
    echo '</table>';
    
 

?>


  