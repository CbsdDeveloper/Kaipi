<?php

session_start();

require '../../kconfig/Db.class.php';  
require '../../kconfig/Obj.conf.php';  
require '../../kconfig/Set.php'; 


$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$anio = $_SESSION['anio'];

$id_rol1    = $_GET['id_rol1'] ;
$regimen= $_GET['regimen'] ;
$detalle_rubro= $_GET['detalle_rubro'] ;

$accion    = $_GET['accion'] ;



if ( $accion == 1){

                $sql = 'SELECT idprov,empleado,programa,cuentae,cuentai,ingreso + descuento as total
                FROM  view_rol_impresion
                where id_rol = '.$bd->sqlvalue_inyeccion($id_rol1, true).' and 
                      regimen = '.$bd->sqlvalue_inyeccion(trim($regimen), true).' and 
                      nombre = '.$bd->sqlvalue_inyeccion(trim($detalle_rubro), true).'
                order by nombre,empleado';



                echo '<table id="jsontableNomina" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
                <thead>
                <tr>
                    <th align="center" width="10%">Identificacion</th>
                   <th align="center" width="58%">Nombre</th>
                   <th align="center" width="5%">Prg.</th>
                   <th align="center" width="10%">Cuenta1</th>
                   <th align="center" width="10%">Cuenta2</th>
                   <th align="center" width="7%">Monto</th>
                    </tr>
               </thead>';


                    $resultado	= $bd->ejecutar($sql);

                    $ingreso   = 0;
                    $descuento = 0;
                    while ($y=$bd->obtener_fila($resultado)){
                     
                      $idprov     = trim($y['idprov']);
                  
                            echo ' <tr>
                                    <td>'.$idprov.'</td>
                                    <td>'.$y['empleado'].'</td>
                                    <td>'.$y['programa'].'</td>
                                    <td><b>'.$y['cuentae'].'</b></td>
                                    <td>'.$y['cuentai'].'</td>
                                    <td align="right">'.$y['total'].'</td>
                                      </tr>';

                                     $ingreso   = $y['total'] +  $ingreso;
                     }

                    echo	'</table><hr>';

 
                    echo	'<div class="col-md-12">
                                      <div class="col-md-6"> &nbsp;</div>
									  <div class="col-md-3"><b>Ingreso: '. $ingreso.'</b></div>
 							</div>';	 

}
 
///-------------------------------------------------

if ( $accion == 2){

    $sql = 'SELECT cuentae,cuentai,sum(ingreso)  +  sum(descuento) total
    FROM  view_rol_impresion
    where id_rol = '.$bd->sqlvalue_inyeccion($id_rol1, true).' and 
          regimen = '.$bd->sqlvalue_inyeccion(trim($regimen), true).' and 
          nombre = '.$bd->sqlvalue_inyeccion(trim($detalle_rubro), true).'
          group by cuentae,cuentai
    order by cuentae';
 

    echo '<table id="jsontableNomina" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
    <thead>
    <tr>
       <th align="center" width="35%">Cuenta1</th>
       <th align="center" width="35%">Cuenta2</th>
       <th align="center" width="30%">Total</th>
        </tr>
   </thead>';


        $resultado	= $bd->ejecutar($sql);

        $ingreso   = 0;
        $descuento = 0;
        while ($y=$bd->obtener_fila($resultado)){
         
          $idprov     = trim($y['idprov']);
      
                echo ' <tr>
                        <td><b>'.$y['cuentae'].'</b></td>
                        <td>'.$y['cuentai'].'</td>
                        <td align="right">'.$y['total'].'</td>
                         </tr>';

                         $ingreso   = $y['total'] +  $ingreso;
         }

        echo	'</table><hr>';


        echo	'<div class="col-md-12">
                          <div class="col-md-6"> &nbsp;</div>
                          <div class="col-md-3"><b>Ingreso: '. $ingreso.'</b></div>
                </div>';	 

}
 //------------------
 
if ( $accion == 3){

    $sql = 'SELECT programa,cuentae,cuentai,sum(ingreso)  + sum(descuento) total
    FROM  view_rol_impresion
    where id_rol = '.$bd->sqlvalue_inyeccion($id_rol1, true).' and 
          regimen = '.$bd->sqlvalue_inyeccion(trim($regimen), true).' and 
          nombre = '.$bd->sqlvalue_inyeccion(trim($detalle_rubro), true).'
          group by programa,cuentae,cuentai
    order by programa,cuentae';
 

    echo '<table id="jsontableNomina" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
    <thead>
    <tr>
       <th align="center" width="20%">Programa</th>
       <th align="center" width="30%">Cuenta1</th>
       <th align="center" width="30%">Cuenta2</th>
       <th align="center" width="20%">Monto</th>
       </tr>
   </thead>';


        $resultado	= $bd->ejecutar($sql);

        $ingreso   = 0;
        $descuento = 0;
        while ($y=$bd->obtener_fila($resultado)){
         
          $idprov     = trim($y['idprov']);
      
                echo ' <tr>
                        <td>'.$y['programa'].'</td>
                        <td><b>'.$y['cuentae'].'</b></td>
                        <td>'.$y['cuentai'].'</td>
                        <td align="right">'.$y['total'].'</td>
                          </tr>';

                         $ingreso   = $y['total'] +  $ingreso;
         }

        echo	'</table><hr>';


        echo	'<div class="col-md-12">
                          <div class="col-md-6"> &nbsp;</div>
                          <div class="col-md-3"><b>Ingreso: '. $ingreso.'</b></div>
                 </div>';	 

}

$div_mistareas = 'ok';

echo $div_mistareas;
?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontableNomina').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":true 
            } );
} );
</script>
  