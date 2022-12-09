<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];
 

_Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO);


 


//-------------------------------------------------------------------------------------
//---------------------------------------------------------------------------

function _Actividades($bd,$obj,$Q_IDUNIDAD,$Q_IDPERIODO){
    
 
    
    $tabla_cabecera =  '<table width="100%" class="table1" border="0" cellspacing="0" cellpadding="0"> ';
    
    
    $sqlO1= 'SELECT   procedimiento,sum(avance) as avance
			  FROM adm.adm_pac
			 WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
                   anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).'
                group by procedimiento
                order by procedimiento' ;
    
    
    
    $stmt_ac = $bd->ejecutar($sqlO1);
    
    $numero2         = 1;
  
   
    echo $tabla_cabecera;
     
    
    while ($x=$bd->obtener_fila($stmt_ac)){
        
        $total_actividad = $x['avance']. ' %';
        
        $actividad =  trim($x['procedimiento']);
        
        echo ' <tr>
        <td width="80%" style="font-size: 15px;padding: 3px"><b>'.$numero2.'.- '.$actividad.'</b></td>
            <td width="20%" style="font-size: 15px;padding: 3px">Avance '.$total_actividad.'</td>
            </tr>
            <tr>
            <td colspan="2" style="padding: 10px">';
        
             _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,trim($x['procedimiento']),$bd,$obj);
             
        echo '</td></tr>';
        
        $numero2 ++;
    }
    
    
 
   echo '</table>';
    
     
   
}
//-------------------------
function _Tareas($Q_IDUNIDAD,$Q_IDPERIODO,$idactividad,$bd,$obj){
    
  
   
        
    
    $sqlO2= 'SELECT   cpc,tipo,tipo_proyecto,detalle,fecha_ejecuta, total
        FROM adm.adm_pac
	   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and 
            procedimiento='.$bd->sqlvalue_inyeccion($idactividad,true). " and 
            estado = 'S' and 
            anio = ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
    ' ORDER BY fecha_ejecuta desc' ;
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
     
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="3%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">No.</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">CPC</td>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Tipo</td>
      <td class="derecha" width="30%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Detalle</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Fecha</td>
      <td class="derecha" width="7%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Total ($)</td>
      <td class="derecha" width="8%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Ejecutado ($)</td> </tr>';
    
    $numero3  = 1;
    
    while ($z=$bd->obtener_fila($stmt_TA)){
        
         
        $detalle            = '<b>'.trim($z['detalle']).'</b>';
        $tarea              = trim($z['cpc']);
        $tipo               = trim($z['tipo']).' / '.trim($z['tipo_proyecto']) ;
        $fecha              = $z['fecha_ejecuta'] ;
        
        $dias               = $z['dias_trascurrido_inicio'] ;

        if (  $dias   < 1 ) {
            $dias = 0;
        }

        $codificado         = number_format($z['total'],2,".",",");
        $ejecutado = 0;
        
 
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$numero3.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tarea.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$tipo.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px">'.$detalle.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: center">'.$fecha.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 12px;padding: 5px;text-align: right">'.$ejecutado.'</td>
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
								
 
 
 