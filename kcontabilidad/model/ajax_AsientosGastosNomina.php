<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$anio = $_SESSION['anio'];

$id_asiento    = $_GET['id_asiento'] ;
$agrupa= $_GET['agrupa'] ;

$aux_pone = 0;

$tiene_auxiliar = 1;

if ( $agrupa == 1){

                $sql = 'SELECT a.cuenta, b.detalle, a.debe, a.haber, a.aux, a.principal, a.codigo1, a.partida, 
                            a.item, a.monto1, a.monto2,a.id_asientod, b.partida_enlace
                        FROM co_asientod a,  co_plan_ctas b
                        where a.id_asiento= '.$bd->sqlvalue_inyeccion($id_asiento, true).' and 
                            b.cuenta = a.cuenta  and b.anio='.$bd->sqlvalue_inyeccion($anio, true);

                            $tiene_auxiliar = 1;


            }else {

                $sql = 'SELECT a.cuenta, b.detalle, sum(a.debe) debe, sum(a.haber) haber, a.aux, a.principal,
                            sum(a.monto1) as monto1, sum(a.monto2) monto2, max(a.id_asientod) id_asientod  
                        FROM co_asientod a,  co_plan_ctas b
                        where a.id_asiento= '.$bd->sqlvalue_inyeccion($id_asiento, true).' and 
                            b.cuenta = a.cuenta  and b.anio='.$bd->sqlvalue_inyeccion($anio, true). ' 
                            group by a.cuenta, b.detalle, a.aux, a.principal';

                            $aux_pone = 1;

                            
                            $tiene_auxiliar = 2;
            }
 
 

echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
     				<th align="center" width="14%">Cuenta</th>
    				<th align="center" width="60%">Detalle</th>
                    <th align="center" width="13%">Debe</th>
    				<th align="center" width="13%">Haber</th>
                    </tr>
    			</thead>';

 
$resultado	= $bd->ejecutar($sql);

while ($y=$bd->obtener_fila($resultado)){
    
    
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
    $boton_gas = ' ';
  if (   $aux_pone == 0 ){
        if( $y['aux'] == 'S'){
            $funcion1  = ' onClick="ViewDetAuxiliar('.$y['id_asientod'].')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalAux" title="Genere asistente de asiento enlace"';
            $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-user"></i></button>&nbsp;';
        }
}  
    //----------------------------------------------------------------------------------------------
    
    $va = $bd->query_array('co_plan_ctas',
                           'credito',
                           'cuenta='.$bd->sqlvalue_inyeccion(trim($y['cuenta']),true)." and
                            estado=".$bd->sqlvalue_inyeccion('S',true)
        );
    
    $boton_anticipo = '';
     
    $contador = '';

   if (  $tiene_auxiliar == 1){

            $va_aux = $bd->query_array('co_asiento_aux',
            'count(*) as nn',
            'id_asientod='.$bd->sqlvalue_inyeccion(trim($y['id_asientod']),true) 
        );

        $valor =  $va_aux['nn'];
        if ( $valor  > 0  ){
                $contador = ' ( '. $valor.' )';
            }
   }else
   {
         $contador = '';
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
    
 
    
    
    
    $acciones = $boton_gas.$boton_del.$boton_ing.$boton_anticipo;
  
    $evento = '';
    $evento1 = '';
    
    $clased = ' class="form-control_asiento" min="0" max="9999999" step="0.01" '. 'id="debe_'.trim($y['id_asientod']).'" name="debe_'.trim($y['id_asientod']).'"'.' ';
    $claseh = ' class="form-control_asiento" min="0" max="9999999" step="0.01" '. 'id="haber_'.trim($y['id_asientod']).'" name="haber_'.trim($y['id_asientod']).'"'.' ';
    
        
    echo ' <tr>
 				<td><b>'.$cuenta.'</b></td>
				<td>'.$acciones.' '.$y['detalle']. $contador .'</td>
                <td align="right">'.trim($y['debe']) .'</td>
                <td align="right">'. trim($y['haber']) .'</td>
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
                 "paging": true, 
                 "info": true,         
                 "lengthChange":true 
            } );
} );
</script>
  