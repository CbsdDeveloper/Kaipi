<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio = $_SESSION['anio'];

$id_asiento    = $_GET['id_asiento'] ;

$sql = 'SELECT a.cuenta, b.detalle, a.debe, a.haber, a.aux, a.principal, a.codigo1, a.partida, 
               a.item, a.monto1, a.monto2,a.id_asientod, b.partida_enlace
        FROM public.co_asientod a,  co_plan_ctas b
        where a.id_asiento= '.$bd->sqlvalue_inyeccion($id_asiento, true).' and 
              b.cuenta = a.cuenta  and b.anio='.$bd->sqlvalue_inyeccion($anio, true);

 
 

echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
                    <th align="center" width="10%">Acciones</th>
    				<th align="center" width="10%">Cuenta</th>
    				<th align="center" width="30%">Detalle</th>
                    <th align="center" width="15%">Debe</th>
    				<th align="center" width="15%">Haber</th>
    				<th align="center" width="20%">partida</th>
                    </tr>
    			</thead>';

/*
<a class="btn btn-xs" href="javascript:open_pop('../model/ajax_delAsientosd','action=del&amp;tid=1079&amp;codigo=298',30,30)">
<i class="icon-trash icon-white"></i></a>  
<a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAux" onclick="ViewDetAuxiliar(1079)"> ViewDetAuxiliar
<i class="icon-user icon-white"></i>
</a><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalCostos" onclick="ViewDetCostos(1079)">
<i class="icon-asterisk icon-white"></i> Controller-co_xpagar_gasto.php
</a>
*/
$resultado	= $bd->ejecutar($sql);

while ($y=$bd->obtener_fila($resultado)){
    
   
    $funcion1  = ' onClick="goToURLDel('."'del'".",". $y['id_asientod'].')" ';
    $title1    = 'title="Eliminar Informacion"';
    $boton_del = '<button   class="btn btn-xs" '.$title1.$funcion1.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
    
    
    //----------------------------------------------------------------------------------------------
    $boton_gas  = '';
    $cuenta     = trim($y['cuenta']);
    $cpartida   = '<span style="color: #A0A0A0">'.trim($y['partida']).'</span>';
    $color      = '';
    
    if (empty($y['debe'])) {
        $debe = 0;
    }else{
        $debe = $y['debe'];
    }
  
    if (empty($y['monto2'])) {
        $monto2 = 0;
    }else{
        $monto2 = $y['monto2'];
    }
    //----------------------------------------------------------------------------------------------
    if( $y['principal'] == 'S'){
        $grupo      = "'".trim($y['item'])."'";
        $partida    = "'".trim($y['partida'])."'";
        $funcion1   = ' onClick="goToURLAsiento('.$y['id_asientod'].','.$debe.','.$monto2.','.$grupo.','.$partida.')" ';
        $title1     = 'data-toggle="modal" data-target="#myModalAsistente" title="Genere asistente de asiento enlace"';
        $boton_gas  = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
        
        $cuenta     = '<b>'.trim($y['cuenta']).'</b>';
        $cpartida   = trim($y['partida']);
        $cpartida   = '<span style="color:#000000"><b>'.$cpartida.'</b></span>';
        $color = ' bgcolor="#EFEFEF" ';
    }
    //----------------------------------------------------------------------------------------------
    $fondo = '';
    
    if( $y['partida_enlace'] == 'ingreso'){
        $fondo = '  <img src="../../kimages/zingreso.png"/>';
    }
    if( $y['partida_enlace'] == 'gasto'){
        $fondo = '    <a href="#" onClick="EnlaceGasto('.$y['id_asientod'].')" title="Enlace partida presupuestaria"><img src="../../kimages/zgasto.png"/></a>';
    }
    //----------------------------------------------------------------------------------------------
    if( $y['aux'] == 'S'){
        $funcion1  = ' onClick="ViewDetAuxiliar('.$y['id_asientod'].')" ';
        $title1    = 'data-toggle="modal" data-target="#myModalAux" title="Genere asistente de asiento enlace"';
        $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-user"></i></button>&nbsp;';
    }
    //----------------------------------------------------------------------------------------------
    
    $va = $bd->query_array('co_plan_ctas',
                           'credito',
                           'cuenta='.$bd->sqlvalue_inyeccion(trim($y['cuenta']),true)." and
                            estado=".$bd->sqlvalue_inyeccion('S',true)
        );
    
    $boton_anticipo = '';
    
    $anticipo_cuenta = substr($cuenta,0,3);
    
    if ( $anticipo_cuenta == '112'){
        
        if ( $y['haber'] > 0 ) {
        
        $grupo      = "'".trim($y['item'])."'";
        $partida    = "'".trim($y['partida'])."'";
        
        
        $funcion1   = ' onClick="goToURLAnticipo('. $y['haber'].','.$y['id_asientod'] .')" ';
        $title1     = 'data-toggle="modal" data-target="#myModalAnticipo" title="Genere asistente de asiento cierre anticipo"';
        $boton_anticipo  = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-bookmark"></i></button>&nbsp;';
        
        $cuenta     = '<b>'.trim($y['cuenta']).'</b>';
        $cpartida   = trim($y['partida']);
        $cpartida   = '<span style="color:#000000"><b>'.$cpartida.'</b></span>';
        $color = ' bgcolor="#EFEFEF" ';
        
        }
    }
    
    
    
    
    $longitud= strlen(trim($va['credito']));
    
    $grupo = '-';
    $boton_ing = '';
    
    if ( $longitud == 2){
        $grupo= trim($va['credito']);
    }
    if ( $longitud == 6){
        $grupo= trim($va['credito']);
    }
    
    if( $grupo <>  '-'){
        
        $funcion1  = ' onClick="PoneEnlace('.$y['id_asientod'].",'".trim($y['cuenta'])."'".","."'".$grupo."'".')" ';
        $title1    = 'data-toggle="modal" data-target="#myModalAuxIng" title="Asistente de asiento enlace"';
        $boton_ing = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
        
    }
    
    
    
    
    $acciones = $boton_gas.$boton_del.$boton_ing.$boton_anticipo;
  
    $evento = '';
    $evento1 = '';
    
    $clased = ' class="form-control_asiento" min="0" max="9999999" step="0.01" '. 'id="debe_'.trim($y['id_asientod']).'" name="debe_'.trim($y['id_asientod']).'"'.' ';
    $claseh = ' class="form-control_asiento" min="0" max="9999999" step="0.01" '. 'id="haber_'.trim($y['id_asientod']).'" name="haber_'.trim($y['id_asientod']).'"'.' ';
    
    
    $evento =  'onChange="actualiza_datod('.'this.value,'. $y['id_asientod'].')" ';
    $evento1 =  'onChange="actualiza_datoh('.'this.value,'. $y['id_asientod'].')" ';
    
    echo ' <tr>
                <td '.$color.'>'.$acciones.$fondo.'</td>
				<td  >'.$cuenta.'</td>
				<td>'.$y['detalle'].'</td>
                <td align="right">'.' <input type="number" '.$evento.$clased.' value='.'"'.trim($y['debe']).'"'.'>'.'</td>
                <td align="right">'.' <input type="number" '.$evento1.$claseh.'value='.'"'.trim($y['haber']).'"'.'>'.'</td>
                <td> '.$cpartida.'</td>
                 </tr>';
 
}

//<input type="hidden">
echo	'</table> ';

$div_mistareas = 'ok';

echo $div_mistareas;
?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontableDetalle').DataTable( {      
                 "searching": true,
                 "paging": false, 
                 "info": true,         
                 "lengthChange":false 
            } );
} );
</script>
  