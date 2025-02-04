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
 

$sql = 'SELECT  cuenta,detalle_cuenta, detalle, sum(debe) as debe , sum(haber) haber,sum(haber) - sum(debe) as saldo ,partida,id_tramite
        FROM view_asientocxp_aux
        where id_asiento= '.$bd->sqlvalue_inyeccion($id_asiento, true).' and 
              anio= '.$bd->sqlvalue_inyeccion($anio, true).' and 
              idprov = '.$bd->sqlvalue_inyeccion($idprov, true)." and cuenta like '213%'
              group by  cuenta,detalle_cuenta, detalle,   partida,id_tramite
              order by  haber desc, cuenta ";

 
  


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
    
 
    $cuenta = trim($y['cuenta']);

    $cpartida = trim($y['partida']);
    
  

    $ACarpeta = $bd->query_array('view_asientocxp_aux',
		'sum(debe) as debe',
		"cuenta = ".$bd->sqlvalue_inyeccion( $cuenta ,true)." and
		 debe > 0  and anio = ".$bd->sqlvalue_inyeccion( $anio ,true)." and
		 idprov = ".$bd->sqlvalue_inyeccion(trim( $idprov  ),true) ." and
         partida = ".$bd->sqlvalue_inyeccion(trim( $cpartida  ),true) ." and
         id_asiento <> ".$bd->sqlvalue_inyeccion(trim( $id_asiento  ),true) ." and
		 id_tramite = ".$bd->sqlvalue_inyeccion( $y['id_tramite'],true)  
		 );
 


    $monto = $y['saldo'];

    if (   $ACarpeta['debe']  > 0 ){

        $monto = $y['saldo'] - round( $ACarpeta['debe'] ,2);
    }    


     echo ' <tr>
 				<td>'.$cuenta.'</td>
				<td>'.$y['detalle_cuenta'].'</td>
                <td align="right">'.round($monto,2).'</td>
                <td> '.$cpartida.'</td>
                 </tr>';
     
      
     $total = $total + $monto; 

     $monto = 0;
    
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
