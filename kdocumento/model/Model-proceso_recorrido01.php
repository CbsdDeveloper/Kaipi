<?php session_start();
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$idcaso = $_GET['id'];
 
 
 _Actividades($bd,$obj,$idcaso);
 
//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

 function _Actividades($bd,$obj,$idcaso){
    
    
     $x = $bd->query_array('flow.view_proceso_caso',   // TABLA
         'idcaso ,nombre_solicita ,email_solicita ,estado ,estado_tramite ,proceso,caso,fecha',                        // CAMPOS
         'idcaso='.$bd->sqlvalue_inyeccion($idcaso,true) // CONDICION
         );
     
     echo '<h4>';
     echo  '<b>'.$x['nombre_solicita'].'</b><br>';
     echo  $x['fecha'].'<br>';
     echo  $x['caso'].'<br>';
     echo  $x['email_solicita'].'<br>';
     echo  $x['estado_tramite'].'<br>';
     echo  $x['proceso'].'<br>';
     
     echo '</h4>';
     
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= 'SELECT caso,fecha,nombre_solicita,fecha_envio,fecha_recepcion,cumple,finaliza,hora_in,sesion_actual,
            dias_tramite,estado_tramite, anio, mes,novedad,dias_trascurrido, idtarea,idcasotarea
		      FROM  flow.view_doc_tarea
			  WHERE idcaso = '.$bd->sqlvalue_inyeccion($idcaso,true).' order by idcasotarea asc' ;
     
    $stmt_ac         = $bd->ejecutar($sqlO1);
    $numero2         = 1;
    
    echo $tabla_cabecera;
    
   echo '<tr>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Instancias</td>
    <td class="derecha" width="27%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Detalle</td>
    <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado </td>
    <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Recepcion</td>
    <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Envio</td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Leido</td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Finaliza</td>
    <td class="derecha" width="8%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
    <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias trascurridos</td>
   <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Accion</td></tr>';


    while ($x=$bd->obtener_fila($stmt_ac)){
        
        
        $tarea              = trim($x['sesion_actual']);
        $estado_tramite     = trim($x['estado_tramite']);
        
        if ($x['cumple'] == 'N'){
            $imagen = ' <img src="../../kimages/ok_no.png">';
        }else{
            $imagen = ' <img src="../../kimages/ok_save.png">';
        }
        
         $novedad = trim($x['novedad']);
        
        $fecha_recepcion    = '';
        $fecha_envio        = '';
         $dias               = '';
        
        $fecha_recepcion= $x['fecha_recepcion'];
        $fecha_envio    = $x['fecha_envio'];
        $dias           = $x['dias_trascurrido'];
        
        $idtarea =  $x['idcasotarea'];
        $user = $bd->__user($tarea);
        $imagen_user = '<img src="../../archivos/user/'.$ima.'"  width="30" height="30"  align="absmiddle">';

        $nombre =trim($user['completo']);

        if ( $x['finaliza'] == 'S' ){
                 $estado = ' <img src="../../kimages/m_verde.png">';
         }else{
                 $estado = ' <img src="../../kimages/m_rojo.png">';

                 $dias = '<b>'. $dias.'</b>';
                 $fecha_envio  = '';
                 $nombre = '<b>'. trim($user['completo']).'</b>';
                 $fecha_recepcion = '<b>'. $fecha_recepcion.'</b>';
                 $novedad = '-';
  
        }
        
   
        $ima = trim($user['url']);
        
      
  
        $estado1= "'S'";
        $estado2= "'N'";
        
        $boton= '<img src="../../kimages/ksavee.png" title="PONE FINALIZADO"  onClick="pone_estado('.$estado1.','.$idtarea.')" title="Ejecutado"/>&nbsp;
        <img src="../../kimages/kedit.png"  title="PONE NO FINALIZADO" onClick="pone_estado('.$estado2.','.$idtarea.')" alt="Sin Ejecutar"/>';
        
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero2.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$novedad.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen_user.' '.  $nombre.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$fecha_recepcion.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$fecha_envio.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$imagen.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$estado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$estado_tramite.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$dias.'</td>
              <td class="filasupe" valign="top">'.$boton.'</td>
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
