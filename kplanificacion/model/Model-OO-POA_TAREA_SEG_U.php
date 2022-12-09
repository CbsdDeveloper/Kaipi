<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];

$idprov= trim($_GET['idprov']);
 
 
_Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO,$idprov);


 


//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO,$idprov){
    
 
    
    echo '<table class="actividad">
     <tr>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
      <td class="derecha" width="40%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tarea</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha Inicio</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Asignado ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Dias</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Avance %</td></tr>';
    echo '</table><br>';
    
    
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= ' SELECT a.actividad, a.aportaen, a.aporte, a.idactividad,a.avance 
        FROM planificacion.view_actividad_poa a
        where a.id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
              a.anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' and 
        	  a.idactividad in (select x.idactividad 
									from  planificacion.view_tarea_poa x
									where   x.anio =a.anio  and   
										    x.anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' and 
                                            x.id_departamento = a.id_departamento and
										    x.responsable =  '.$bd->sqlvalue_inyeccion($idprov,true).' and 
										    x.idactividad  = a.idactividad
									)
        order by a.actividad';

    
  
    
    //a.idperiodo,
    
    $stmt_ac = $bd->ejecutar($sqlO1);
    
    $numero2         = 1;
  
   
    echo $tabla_cabecera;
     
    
    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $total_actividad = $x['avance']. ' %';
        
           
        $actividad =  strtoupper(trim($x['actividad']));

        echo ' <tr>
        <td width="80%" style="font-size: 12px;padding: 2px" bgcolor="#dfdfdf">'.$numero2.'.- '.$actividad.'</td>
        <td width="20%" style="font-size: 14px;padding: 2px;padding-right:30px" bgcolor="#dfdfdf" align="right"><b>'.$total_actividad.'</b></td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 1px">';
        _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$x['idactividad'],$bd,$obj,$idprov);
        echo '</td></tr>';
        
        $numero2 ++;
    }
    
    
 
 
   echo '</table>';
    
     
   
}
//-------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad,$bd,$obj,$idprov){
    
  
    
    $sqlO2= 'SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma,
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial,
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen,dias_trascurrido_inicio,
                        avance
        FROM planificacion.view_tarea_poa
	   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
            responsable='.$bd->sqlvalue_inyeccion($idprov,true). " and 
            idactividad=".$bd->sqlvalue_inyeccion($idactividad,true). " and 
            estado = 'S'
       ORDER BY fechainicial desc" ;
    
    
    
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
 
    
    echo '<table class="actividad">';
    
    
    $numero3  = 1;
    
    while ($z=$bd->obtener_fila($stmt_TA)){
        
        $idtarea            = $z['idtarea'];
         
        $tarea              = '<a href="#" onclick="busquedatarea('.$idtarea .')"><b>'.trim($z['tarea']).'</b></a>';
              
        
        $fecha              = $z['fechainicial'] ;
        
        $dias               = $z['dias_trascurrido_inicio'] ;

        if (  $dias   < 1 ) {
            $dias = 0;
        }

        $codificado         = number_format($z['codificado'],2,".",",");
        $ejecutado          = number_format($z['ejecutado'] ,2,".",",");
      
        $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object" style="width:32px">';
        
        if ($z['cumplimiento'] == 'N'){
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" align="absmiddle" >';
        }elseif ($z['cumplimiento'] == 'A'){
            $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle" >';
        }elseif ($z['cumplimiento'] == 'B'){
            $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" align="absmiddle" >';
        }elseif ($z['cumplimiento'] == 'C'){
            $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" align="absmiddle" >';
        }elseif ($z['cumplimiento'] == 'S'){
            $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" align="absmiddle" >';
        }
        
 
       
        
        echo '<tr>
              <td class="filasupe"  width="5%" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe"  width="5%" style="font-size: 12px;padding: 5px">'.$imagen.'</td>
              <td class="filasupe"  width="40%" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe"  width="10%" style="font-size: 12px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe"  width="10%" style="font-size: 12px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe"  width="10%" style="font-size: 12px;padding: 5px;text-align: right">'.$ejecutado.'</td>
              <td class="filasupe"  width="10%" style="font-size: 12px;padding: 5px;text-align: center">'. $dias .'</td>
              <td class="filasupe"  width="10%" style="font-size: 12px;padding: 5px;text-align: center">'.$z['avance'].' %'.'</td>
            </tr>';
        
     
        $numero3 ++;
    }
    
    
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
								
 
 
 