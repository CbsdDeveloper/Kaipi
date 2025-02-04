<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

  
$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

//$registro      =  $_SESSION['ruc_registro'];

$idtramite   = $_GET['idtramite'] ;

 
$sql = '  SELECT id_tramite_det, id_tramite, partida,  iva,   certificado,clasificador, fuente, actividad   
            FROM presupuesto.view_dettramites
            where id_tramite =  '.$bd->sqlvalue_inyeccion($idtramite, true).'  
			order by id_tramite_det';

 
echo '<table id="jsontableparcial" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="30%">Partida</th>
                    <th align="center" width="10%">Clasificador</th>
                    <th align="center" width="10%">Fuente</th>
    				<th align="center" width="25%">Certificacion</th>
                    <th align="center" width="25%">Compromiso</th>
    				</tr>
    			</thead>';

       
        $resultado	= $bd->ejecutar($sql);

        while ($y=$bd->obtener_fila($resultado)){
 
         
            $evento1 =  'onChange="actualiza_parcial('.$y['certificado'].",this.value,". $y['id_tramite_det'].')" ';
    
            echo ' <tr>
				<td>'.$y['partida'].'</td>
                <td>'.$y['clasificador'].'</td>
                <td>'.$y['fuente'].'</td>
                <td align="right">'.' <input type="number" class="form-control" min="0" max="9999999" step="0.01" readonly value="'.round($y['certificado'],2).'"    id="sa_'.trim($y['id_tramite_det']).'" name="sa_'.trim($y['id_tramite_det']).'">'.'</td>
                <td align="right">'.' <input type="number" '.$evento1.' class="form-control" min="-999999999" max="9999999999" step="0.01"  value="0"  id="di_'.trim($y['id_tramite_det']).'" name="di_'.trim($y['id_tramite_det']).'">'.'</td>
            </td> 
                 </tr>'; 
            
        }
       echo	'</table> '; 
        
       $Viewdetalle = 'ok';

       echo $Viewdetalle;
?>

  