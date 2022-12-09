<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];


_Objetivos_indicadores($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO);





//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Objetivos_indicadores($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO){
    
    
    
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
 
    
    
    $sqlO1= 'SELECT    anio, idperiodo, idobjetivo, objetivo, id_departamento, nombre, numero
								   FROM planificacion.view_indicadores_oo_res
				 				  WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
                                        anio= '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                                        order by nombre' ;
 
    
    $stmt_ac = $bd->ejecutar($sqlO1);
    
    $numero2         = 1;
    $total_actividad = '0.00 %';
    
    echo $tabla_cabecera;
    
    
    
    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $actividad       =  trim($x['objetivo']);
        $total_actividad =   ($x['numero']);
        
        echo ' <tr>
        <td width="75%" style="font-size: 15px;padding: 3px"><b>'.$numero2.'.- '.$actividad.'</b></td>
            <td width="25%" style="font-size: 15px;padding: 3px" valign="top" >No.Indicadores '.$total_actividad.'</td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 10px" valign="top" >';
                  _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$x['idobjetivo'],$bd,$obj);
        echo '</td></tr>';
        
        $numero2 ++;
    }
    
    
    
    echo '</table>';
    
    
    
}
//-------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idobjetivo,$bd,$obj){
    
 
    $sqlO2= 'SELECT   idobjetivoindicador, idobjetivo, id_departamento, nombre, programa, indicador, objetivo, aporte, 
    detalle, tipoformula, idperiodo, anio, estado, periodo, valor1, valor2, variable1, variable2, 
    formula, meta, medio, sesion, creacion, sesionm, modificacion,resultado
        FROM planificacion.view_indicadores_oo
	   WHERE idobjetivo = '.$bd->sqlvalue_inyeccion($idobjetivo,true).'
       ORDER BY indicador' ;
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="3%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Estado</td>
      <td class="derecha" width="35%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Indicador</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Periodo</td>
      <td class="derecha" width="25%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Formula</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Meta</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Avance</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Actualizado</td></tr>';
    
    $numero3  = 1;
    
    while ($z=$bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $indicador           = trim($z['indicador']);
        $periodo             = trim($z['periodo']);
        $formula             = $z['formula'] ;
        $meta                = $z['meta'] ;
        $ejecutado          = number_format($z['resultado'] ,2,".",",");
        $sesionm           = trim($z['sesionm']);
        
        
        $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object" style="width:32px">';
        /*
        
        if ( $dias  <= 30 ) {
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" class="media-object" style="width:32px">';
            if ( trim($z['cumplimiento'])  == 'S' ) {
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" class="media-object" style="width:32px">';
            }
            if ( trim($z['cumplimiento'])  == 'P' ) {
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" class="media-object" style="width:32px">';
            }
        }
        
        if ( $dias  >= 30 ) {
            $imagen = ' <img src="../../kimages/if_bullet_red_35785.png" class="media-object" style="width:32px">';
            
            if ( trim($z['cumplimiento'])  == 'S' ) {
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png" class="media-object" style="width:32px">';
            }
            if ( trim($z['cumplimiento'])  == 'P' ) {
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png" class="media-object" style="width:32px">';
            }
        }
        */
        
        
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$imagen.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$indicador.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$periodo.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$formula.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right"><b>'.$meta.'</b></td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right"><b>'.$ejecutado.'</b></td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$sesionm.'</td>
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
								
 
 
 