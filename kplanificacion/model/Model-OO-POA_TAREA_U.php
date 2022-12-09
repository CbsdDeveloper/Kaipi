<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];


$estado1   = 'S';
 

_Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO,$estado1);


 


//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO,$estado1){
    
 
    
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= 'SELECT   unidad,id_departamento
								   FROM planificacion.view_actividad_poa
				 				  WHERE 
                                         anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                group by  unidad,id_departamento               
                order by unidad,id_departamento ' ;
    
    //a.idperiodo,
    
    $stmt_ac = $bd->ejecutar($sqlO1);
    
    $numero2         = 1;
  
   
    echo $tabla_cabecera;
     
    
    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $total_actividad = $x['avance']. ' %';
        
        $actividad =  trim($x['unidad']);

        $Q_IDUNIDAD =  $x['id_departamento'];

        echo ' <tr>
        <td width="80%" style="font-size: 15px;padding: 3px"><b>'.$numero2.'.- '.$actividad.'</b></td>
            <td width="20%" style="font-size: 15px;padding: 3px">Avance '.$total_actividad.'</td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 10px">';
             _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$x['idactividad'],$bd,$obj,$estado1);
        echo '</td></tr>';
        
        $numero2 ++;
    }
    
    
 
   echo '</table>';
    
     
   
}
//-------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad,$bd,$obj,$estado1){
    
  
    
    $sqlO2= 'SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma,
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial,
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,justificacion,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen,dias_trascurrido_inicio
        FROM planificacion.view_tarea_poa
	   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
           estado = '.$bd->sqlvalue_inyeccion($estado1,true)."   
       ORDER BY fechainicial desc" ;
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
      <td class="derecha" width="50%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Inicio</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias</td></tr>';
    
    $numero3  = 1;

    $codificado1 = 0;
    $ejecutado1 = 0 ;
    
    while ($z=$bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $nombre_funcionario = trim($z['nombre_funcionario']);
        $tarea              = trim($z['tarea']);

        $justificacion              = trim($z['justificacion']);
        $fecha              = $z['fechainicial'] ;
        
        $dias               = $z['dias_trascurrido_inicio'] ;

        if (  $dias   < 1 ) {
            $dias = 0;
        }

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
        

        if ($z['estado'] == 'N'){
            $imagen = ' <img src="../../kimages/if_error_36026.png" class="media-object" style="width:32px">';
            $tarea = $tarea. '   <span style="color: #A6080A">JUSTIFICACION:'.$justificacion.'</span> ';
        } 
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$ejecutado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$dias.'</td>
            </tr>';
        
     
        $numero3 ++;
        $codificado1 = $codificado1 + $z['codificado'];
        $ejecutado1  = $ejecutado1 + $z['ejecutado'] ;

    }
    
    

    echo '<tr>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center"> </td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px"> </td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px"> </td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px"> </td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">TOTAL</td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right"><b>'.number_format($codificado1,2).'</b></td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right"><b>'.number_format($ejecutado1,2).'</b></td>
    <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center"> </td>
  </tr>';

    echo '</table>';

     
    
    return 0;
}
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
function EstadoPoa( $Q_IDPERIODO ,$bd ){
    
    
    $AUnidad = $bd->query_array('presupuesto.pre_periodo',
        'tipo,estado',
        'estado='.$bd->sqlvalue_inyeccion('ejecucion',true). ' and
			 anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
        );
    
    $valida = 1;
    
    if ( $AUnidad['tipo']  == 'elaboracion'  ){
        $valida = 0;
    }
    
    
    return $valida ;
    
}

?>
								
 
 
 