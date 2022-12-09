<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];

$sesion 	 =  $_SESSION['email'];

 
$AUnidad = $bd->query_array('planificacion.view_unidad_oo',
							'idperiodo, anio, nombre, programa, ambito, objetivos', 
							'id_departamento='.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true). ' and 
							 anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
							);
 

echo ' <h4><b>Unidad '.$AUnidad['nombre'].'</b></h4>  ';

Indicadores($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj,$sesion);

 
//-----------------------------------------------------------
//--------------------------------------------------------
function Indicadores($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion){
	
    $sqlOO= 'SELECT   objetivo,   numero,idobjetivo
				FROM planificacion.view_indicadores_oo_res
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true);
    
    
    $stmt_oo = $bd->ejecutar($sqlOO);
    
    echo ' <table class="table table-bordered table-hover">
       		 <thead>
              <tr>
                <th width="25%" >Objetivo</th>
                <th width="25%">Indicador</th>
                <th width="10%">Meta</th>
				<th width="10%">Periodo</th>
                <th width="10%">Formula</th>
                <th width="20%">Medio Verificacion</th>
             </tr><tbody>';
    
    while ($y=$bd->obtener_fila($stmt_oo)){
        Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion,$y['numero'],$y['idobjetivo']);
    }
    echo  ' </tbody></table>';
    
	
	
	
}
//--------------------------------------------------
function Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$sesion,$nro,$IDOBJETIVO){
    
    $sqlOODetalle= 'SELECT    objetivo, indicador,  meta, formula,medio,   periodo,idobjetivoindicador
				FROM planificacion.view_indicadores_oo
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  estado = '.$bd->sqlvalue_inyeccion('S',true).' AND
					  idobjetivo = '.$bd->sqlvalue_inyeccion($IDOBJETIVO,true);
    
    
    
    
    $stmtDetalle = $bd->ejecutar($sqlOODetalle);
    
    $i = 0;
    
    while ($x=$bd->obtener_fila($stmtDetalle)){
        
     /*  $boton ='<button class="btn btn-xs"
						onClick="javascript:goToIndicador('.$x['idobjetivoindicador'].')" data-toggle="modal" data-target="#myModalIndicador" >
					<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
        
       */ 
        $imagen = '<img  align="absmiddle" src="../../kimages/indicadores.png"/> ';
        
        $imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
        
        if ($nro == 1){
            echo '<tr>
		                <td>'.$imageno.$x['objetivo'].'</td>
		                <td>'.$imagen.$x['indicador'].'</td>
		                <td>'.$x['meta'].'</td>
		                <td>'.$x['periodo'].'</td>
                         <td>'.$x['formula'].'</td>
                         <td>'.$x['medio'].'</td>
           		      </tr>';
        }else {
            if ($i == 0){
                echo '<tr>
		     				<td rowspan="'.$nro.'">'.$imageno.$x['objetivo'].'</td>
		     				<td>'.$imagen.$x['indicador'].'</td>
		     				<td>'.$x['meta'].'</td>
		     				<td>'.$x['periodo'].'</td>
                            <td>'.$x['formula'].'</td>
                            <td>'.$x['medio'].'</td>
 	     				</tr>';
            }else{
                echo '<tr>
				                  <td>'.$imagen.$x['indicador'].'</td>
				                  <td>'.$x['meta'].'</td>
				                  <td>'.$x['periodo'].'</td>
                                  <td>'.$x['formula'].'</td>
                                  <td>'.$x['medio'].'</td>
 				            </tr>';
            }
        }
        $i++;
    }
    
    
    
}
?>
 
 
 