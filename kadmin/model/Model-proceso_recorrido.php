<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$idcaso = $_GET['id'];


_Actividades($bd,$obj,$idcaso);

//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Actividades($bd,$obj,$idcaso){
    
    
    $x = $bd->query_array('flow.view_proceso_caso',   // TABLA
        'idcaso ,nombre_solicita ,email_solicita ,estado ,estado_tramite ,proceso',                        // CAMPOS
        'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true) // CONDICION
        );
    
    echo '<h4>';
    echo  '<b>'.$x['nombre_solicita'].'</b><br>';
    echo  $x['email_solicita'].'<br>';
    echo  $x['estado_tramite'].'<br>';
    echo  $x['proceso'].'<br>';
    
    echo '</h4>';
    
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= 'SELECT tarea, novedad, cumple, finaliza,
                    fecha_recepcion,condicion,fecha_envio,sesion_nombre,dia_ejecuta as dias_trascurrido
		      FROM flow.proceso_tarea_caso
			  WHERE idcaso = '.$bd->sqlvalue_inyeccion($idcaso,true);
    
    
    $tarea_nro = $bd->query_array('flow.proceso_tarea_caso','count(*) as numero ', 'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true));
    
    
    
    $stmt_ac = $bd->ejecutar($sqlO1);
    
    $numero2         = 1;
    
    
    echo $tabla_cabecera;
    
    echo '<tr>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Grafico</td>
    <td class="derecha" width="25%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
    <td class="derecha" width="25%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Novedad</td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Cumple</td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
    <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Recepcion</td>
    <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Envio</td>
    <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable </td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias trascurridos</td></tr>';
    
    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $novedad = trim($x['novedad']);
        $tarea              = trim($x['tarea']);
        
        $numero3='';
        
        if ($x['cumple'] == 'N'){
            $imagen = ' <img src="../../kimages/ok_no.png">';
        }else{
            $imagen = ' <img src="../../kimages/ok_save.png">';
        }
        
        
        if ( $x['condicion'] == 'S' ){
            $numero3 = ' <img src="../../kimages/tab_condicion.png">';
        }else {
            if ( $numero2 == 1){
                
                $numero3 = ' <img src="../../kimages/tab_inicio.png">';
                
            }else{
                if ( $numero2 == $tarea_nro['numero']){
                    
                    $numero3 = ' <img src="../../kimages/tab_fin.png">';
                }else {
                    $numero3 = ' <img src="../../kimages/tab_tarea.png">';
                }
                
            }
            
        }
        
        $fecha_recepcion= '';
        $fecha_envio = '';
        $sesion_nombre ='';
        $dias = '';
        
        
        if ( $x['finaliza'] == 'S' ){
            $estado = ' <img src="../../kimages/m_verde.png">';
            $fecha_recepcion= $x['fecha_recepcion'];
            $fecha_envio = $x['fecha_envio'];
            $sesion_nombre =  $x['sesion_nombre'];
            $dias= $x['dias_trascurrido'];
        }else{
            if (empty($x['sesion_nombre'])){
                $estado = ' <img src="../../kimages/m_rojo.png">';
            }else {
                $estado = ' <img src="../../kimages/m_amarillo.png">';
                $fecha_recepcion= $x['fecha_recepcion'];
                $fecha_envio = $x['fecha_envio'];
                $sesion_nombre =  $x['sesion_nombre'];
                $dias= $x['dias_trascurrido'];
            }
        }
        
        
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$novedad.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$estado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$fecha_recepcion.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$fecha_envio.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$sesion_nombre.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$dias.'</td>
            </tr>';
        
        $numero2 ++;
    }
    
    
    
    echo '</table>';
    
    
    
}
//-------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad,$bd,$obj){
    
    
    
    $sqlO2= 'SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma,
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial,
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen,dias_trascurrido_inicio
        FROM planificacion.view_tarea_poa
	   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
            idactividad='.$bd->sqlvalue_inyeccion($idactividad,true). '
       ORDER BY fechainicial desc' ;
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="3%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
      <td class="derecha" width="25%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Inicio</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado ($)</td>
      <td class="derecha" width="8%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias</td></tr>';
    
    $numero3  = 1;
    
    while ($z=$bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        
        $fecha              = $z['fechainicial'] ;
        $dias               = $z['dias_trascurrido_inicio'] ;
        $codificado         = number_format($z['codificado'],2,".",",");
        $ejecutado          = number_format($z['ejecutado'] ,2,".",",");
        
        $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object" style="width:32px">';
        
        if ($z['cumplimiento'] == 'N'){
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object" style="width:32px">';
        }elseif ($z['cumplimiento'] == 'A'){
            $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" class="media-object" style="width:32px">';
        }elseif ($z['cumplimiento'] == 'B'){
            $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" class="media-object" style="width:32px">';
        }elseif ($z['cumplimiento'] == 'C'){
            $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" class="media-object" style="width:32px">';
        }elseif ($z['cumplimiento'] == 'S'){
            $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" class="media-object" style="width:32px">';
        }
        
        $nombre_funcionario='';
        $tarea = '';
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$nombre_funcionario.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$ejecutado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$dias.'</td>
            </tr>';
        
        
        $numero3 ++;
    }
    
    
    echo '</table>';
    
    
    
    return 0;
}
//-------------------------------------------------------------------------------------


?>
