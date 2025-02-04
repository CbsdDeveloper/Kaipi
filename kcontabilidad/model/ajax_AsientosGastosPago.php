<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 

$id_asiento    = $_GET['id_asiento'] ;

$idprov        = $_GET['idprov'] ;


$anio = $_SESSION['anio'];
 

$sql = 'SELECT cuenta,detalle_cuenta, detalle, debe, haber, partida,id_tramite,id_asientod
        FROM view_asientocxp_aux
        where id_asiento= '.$bd->sqlvalue_inyeccion($id_asiento, true).' and 
              anio= '.$bd->sqlvalue_inyeccion($anio, true).' and 
              idprov = '.$bd->sqlvalue_inyeccion($idprov, true).'
        order by  haber desc, cuenta';

 
  


echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="20%">Cuenta</th>
    				<th align="center" width="40%">Detalle</th>
    				<th align="center" width="20%">Monto Pago</th>
    				<th align="center" width="20%">partida</th>
                    </tr>
    			</thead>';
 
$resultado	= $bd->ejecutar($sql);


$total = 0;

while ($y=$bd->obtener_fila($resultado)){
    
   /*
    $funcion1  = ' onClick="goToURLDel('."'del'".",". $y['id_asientod'].')" ';
    $title1    = 'title="Eliminar Informacion"';
    $boton_del = '<button   class="btn btn-xs" '.$title1.$funcion1.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
     */
    $cuenta = trim($y['cuenta']);
    $cpartida = trim($y['partida']);
     echo ' <tr>
 				<td>'.$cuenta.'</td>
				<td>'.$y['detalle_cuenta'].'</td>
                <td align="right">'.$y['haber'].'</td>
                <td> '.$cpartida.'</td>
                 </tr>';
     
      
     $total = $total + $y['haber']; 
    
  }

  echo ' <tr>
 				<td> </td>
				<td>Total </td>
                <td align="right"> <b>'.$total.'</b></td>
                <td> - </td>
                 </tr>';
//<input type="hidden">
echo	'</table> ';

$div_mistareas = 'ok';

echo $div_mistareas;
?>
