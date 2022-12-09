<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
 
$bd	   =	new  Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$anio          = $_SESSION['anio'] ;
 


$fecha_caja = $_GET["fecha_caja"];
$parte_caja = trim($_GET["parte_caja"]);

$sql = "SELECT a.cuenta,
                   b.detalle,
                   a.partida,
                  a.debe,
                 a.haber,a.tramite,a.id_manual
        FROM co_asientod_manual a,  co_plan_ctas b
        where b.anio= ".$bd->sqlvalue_inyeccion($anio, true)." and
              a.fecha= ".$bd->sqlvalue_inyeccion($fecha_caja, true)." and
              a.parte= ".$bd->sqlvalue_inyeccion($parte_caja, true)." and
              b.cuenta = a.cuenta 
        order by a.cuenta,a.debe";
 
 

echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
     				<th align="center" width="15%">Cuenta</th>
    				<th align="center" width="30%">Detalle</th>
                    <th align="center" width="15%">Partida</th>
                    <th align="center" width="10%">Debe</th>
                    <th align="center" width="10%">Haber</th>
    				<th align="center" width="10%">Tramite</th>
                    <th align="center" width="10%">Acciones</th>
                     </tr>
    			</thead>';
 

$resultado	= $bd->ejecutar($sql);

$debe = 0;
$haber = 0;
 
while ($y=$bd->obtener_fila($resultado)){
    
    $cpartida       = '<span style="color: #0400ff">'.trim($y['partida']).'</span>';
    $boton_gas      = '';
    $color          = '';
     $cuenta         = trim($y['cuenta']);
          
    $i              = $y['id_manual'] ;
    
    $funcion1       = ' onClick="goToURver(0,'.$y['id_manual'].')" ';
    $boton_gas      = '<button   class="btn btn-xs" '.$funcion1.' ><i class="glyphicon glyphicon-trash"></i></button>&nbsp;';
    
    
      
    $acciones       = $boton_gas;
    $evento1        = '';
    
    
    
 
    
    $claseh = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '. 
         'id="haber_'.trim($i).'" name="haber_'.trim($i).'"'.' ';
    
     $evento1 =  'onChange="actualiza_datoh('.'this.value,'. $i.',2)" ';
    
     $evento1 = '';
     $clased = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '.
         'id="debe_'.trim($i).'" name="debe_'.trim($i).'"'.' ';
     
     $evento1 =  'onChange="actualiza_datoh('.'this.value,'. $i.',1)" ';
     
     $evento1 = '';
     
     
     if ( $y['tramite'] > 0 ){
         $tramite = '<b>'.$y['tramite'].'</b>';
     }else{
         $tramite = '-';
     }
     
    echo ' <tr>
 				<td>'.$cuenta.'</td>
				<td>'.$y['detalle'].'</td>
                <td>'.$cpartida.'</td>
                <td align="right">'.' <input type="number" '.$evento1.$clased.'value='.$y['debe'].'>'.'</td>
                <td align="right">'.' <input type="number" '.$evento1.$claseh.'value='.$y['haber'].'>'.'</td>
               <td>'.$tramite.'</td>
                <td '.$color.'>'.$acciones.'</td>
                 </tr>';
 
    $debe =  $debe + $y['debe'];
    $haber = $y['haber'] + $haber;
    
}

 
//<input type="hidden">
echo	'</table> ';

$saldo = $debe- $haber;

$div_mistareas = '<h4><b>DEBE: '.number_format($debe,2).'<br>HABER: '.number_format($haber,2).'<br>Saldo: '.number_format($saldo,2).'</b></h4>';

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

  