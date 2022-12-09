<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
 
$bd	   =	new  Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$anio          = $_SESSION['anio'] ;
 


$fecha_caja = $_GET["fecha_caja"];
 
 $cabecera =  '<table class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
            <thead>
            <tr>
                <th align="center" width="20%">Cuenta</th>
                <th align="center" width="40%">Detalle</th>
                <th align="center" width="20%">Partida</th>
                <th align="center" width="10%">Debe</th>
                <th align="center" width="10%">Haber</th>
                 </tr>
            </thead>';

$sql = "SELECT id_asiento, asiento_detalle
        FROM view_diario_detalle
        where tipo_mov= ".$bd->sqlvalue_inyeccion('R', true)." and
              fecha= ".$bd->sqlvalue_inyeccion($fecha_caja, true)." and
              estado= ".$bd->sqlvalue_inyeccion('aprobado', true)."  
               group  by id_asiento, asiento_detalle";

 
   $resultado	= $bd->ejecutar($sql);

    echo '<ul class="list-group">';

    while ($y=$bd->obtener_fila($resultado)){

        $cuenta         = trim($y['id_asiento']).' '. trim($y['asiento_detalle']);

          echo  '<li class="list-group-item">'.  $cuenta.' </li>';

          
                $sql1 = "SELECT  cuenta, partida,debe,haber
                FROM view_diario_detalle
                where id_asiento= ".$bd->sqlvalue_inyeccion( $y['id_asiento'] , true)."  
                     order by cuenta";

                $resultado1	= $bd->ejecutar($sql1);     

                echo  $cabecera;
                while ($xx=$bd->obtener_fila($resultado1)){

                    $x_cuenta = $bd->query_array('co_plan_ctas',   // TABLA
                    'detalle',                        // CAMPOS
                    'cuenta='.$bd->sqlvalue_inyeccion( trim($xx['cuenta']) ,true)  
                    );

 
                    echo ' <tr>
                            <td>'.$xx['cuenta'].'</td>
                            <td>'.$x_cuenta['detalle'].'</td>
                            <td>'.$xx['partida'].'</td>
                            <td>'.$xx['debe'].'</td>
                            <td>'.$xx['haber'].'</td>';

                    echo ' </tr>';        
                }
                echo	'</table> ';

    }

 

echo '</ul>';


 

?>