<?php  
session_start();  
 
    require('../view/Head.php') ;

    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
 	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
    $fecha     = $_GET['fecha'] ;
    $anio      = $_GET['anio'] ;
     

    $sql = 'SELECT cuenta_1, nivel_11, sum(deudor_1) as deudor,sum(acreedor_1) as acreedor
            FROM  co_reciprocas
            group by cuenta_1 ,nivel_11 
            order by cuenta_1 ,nivel_11';


echo ' <div class="col-md-12" style="padding: 40px">  <h4>RESUMEN TRANSACCIONES RECIPROCAS</h4>';

   
        cabecera_tabla( 'jsontableDetalle') ;
   
        $resultado	= $bd->ejecutar($sql);

        while ($y=$bd->obtener_fila($resultado)){
        
                $cuenta  = trim($y['cuenta_1']).'.'.trim($y['nivel_11']);

                $va = $bd->query_array('co_resumen_balance',
                                      'SUM(debe) AS debe, SUM(haber) as haber', 
                                    'grupo='.$bd->sqlvalue_inyeccion(trim($y['cuenta_1']),true)." and 
                                    subgrupo=".$bd->sqlvalue_inyeccion(trim($y['nivel_11']),true)." and 
                                    anio=".$bd->sqlvalue_inyeccion(  $anio,true)
                );

                echo ' <tr>
				<td><b>'.$cuenta.'</b></td>
				<td>'.$y['cuenta_1'].'</td>
                <td>'.$y['nivel_11'].'</td>
                <td align="right"><b>'.$y['deudor'].'</b></td>
                <td align="right"><b>'.$y['acreedor'].'</b></td>
                <td align="right">'.$va['debe'].'</td>
                <td align="right">'.$va['haber'].'</td>
                 </tr>';

            
        }

        echo	'</table> ';
        
        
 
    
        
      echo '<h4>Resumen cuentas de cierre archivo <span class="label label-default"></span></h4>';
   
    
      $sql2 = 'SELECT cuenta_2, nivel_21, sum(deudor_2) as deudor,sum(acreedor_2) as acreedor
      FROM  co_reciprocas
      group by cuenta_2 ,nivel_21 
      order by cuenta_2 ,nivel_21';

        
        cabecera_tabla( 'jsontableSegundo') ;
        
        $resultado1	= $bd->ejecutar($sql2);

        while ($y=$bd->obtener_fila($resultado1)){

                $cuenta  = trim($y['cuenta_2']).'.'.trim($y['nivel_21']);

                $va = $bd->query_array('co_resumen_balance',
                                    'SUM(debe) AS debe, SUM(haber) as haber', 
                                    'grupo='.$bd->sqlvalue_inyeccion(trim($y['cuenta_2']),true)." and 
                                    subgrupo=".$bd->sqlvalue_inyeccion(trim($y['nivel_21']),true)." and 
                                    anio=".$bd->sqlvalue_inyeccion(  $anio,true)
                );

                echo ' <tr>
                <td><b>'.$cuenta.'</b></td>
                <td>'.$y['cuenta_2'].'</td>
                <td>'.$y['nivel_21'].'</td>
                <td align="right"><b>'.$y['deudor'].'</b></td>
                <td align="right"><b>'.$y['acreedor'].'</b></td>
                <td align="right">'.$va['debe'].'</td>
                <td align="right">'.$va['haber'].'</td>
                </tr>';

            
        }

        echo	'</table> ';


    echo ' </div>';

    $div_mistareas = 'ok';
    
    echo $div_mistareas;
 
 /*
 cabecera de tabla
 */
function cabecera_tabla( $id){

    echo '<table id="'.$id.'" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
        <thead>
        <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="2" align="center">Resumen Reciprocas</td>
        <td colspan="2" align="center">Resumen Balance</td>
       </tr>
        <tr>
        <th align="center" width="20%">Cuenta</th>
        <th align="center" width="20%">Grupo</th>
        <th align="center" width="20%">Subgrupo</th>
        <th align="center" width="10%">Deudor</th>
        <th align="center" width="10%">Acreedor</th>
        <th align="center" width="10%">Deudor</th>
        <th align="center" width="10%">Acreedor</th>
        </tr>
        </thead>';

 }
?> 
