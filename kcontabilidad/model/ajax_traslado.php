<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$anio = $_SESSION['anio'];

 

$accion    = $_GET['accion'] ;



if ( $accion == 'visor'){

                $sql = 'SELECT cuenta1, nombre, cuenta2,id_traslado FROM co_traslado order by cuenta1 ';



                echo '<table id="jsontabletraslado" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
                <thead>
                <tr>
                <th align="center" width="10%">Codigo</th>
                    <th align="center" width="20%">Cuenta Actual</th>
                   <th align="center" width="40%">Nombre</th>
                   <th align="center" width="20%">Cuenta Traslado</th>
                   <th align="center" width="10%">Existe Cuenta</th>
                    </tr>
               </thead>';


                    $resultado	= $bd->ejecutar($sql);

                    $ingreso   = 0;
                    $descuento = 0;
                    while ($y=$bd->obtener_fila($resultado)){
                     
                      $cuenta2     = trim($y['cuenta2']);

                  
                      
                      $datos = $bd->query_array('co_plan_ctas','count(*) as nn', 
                                                      'cuenta like '.$bd->sqlvalue_inyeccion($cuenta2.'%',true). " and 
                                                        anio=".$bd->sqlvalue_inyeccion($anio,true)." and 
                                                        univel= 'S'"
                                                    );


                     if ( $datos['nn'] > 0 ){
                        $existe = 'SI';
                      }else{
                        $existe = 'NO';
                    }

                             echo ' <tr>
                                     <td>'.$y['id_traslado'].'</td>
                                    <td>'.$y['cuenta1'].'</td>
                                    <td>'.$y['nombre'].'</td>
                                    <td><b>'.$y['cuenta2'].'</b></td>
                                    <td>'.$existe.'</td>
                                       </tr>';

                      }

                    echo	'</table><hr>';
 

}
  

$div_mistareas = 'ok';

echo $div_mistareas;
?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontabletraslado').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":true 
            } );
} );
</script>
  