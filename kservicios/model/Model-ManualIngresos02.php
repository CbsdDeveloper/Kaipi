<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

 
 
$bd	   =	new  Db ;
$obj   = 	new objects;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
$fecha_caja = $_GET["fecha_caja"];

$id         = $_GET["id"];


$periodo = explode('-',$fecha_caja);

$mes = $periodo[1];
 

if ( $id ==  10 ){

                echo '<h4>Detalle Diario de Especies</h4>';
                $formulario  = '';
                $action      = '';
                
                $sql = "select  a.fecha,
                                b.producto as detalle,
                                min(a.comprobante) as inicial, 
                                max(a.comprobante) as final,
                                sum(a.cantidad) as cantidad,
                                COALESCE(sum(a.base),0) total
                    from rentas.view_ren_especies a, rentas.ren_servicios b
                    where a.fecha = ".$bd->sqlvalue_inyeccion( $fecha_caja,true)." and 
                         a.idproducto_ser = b.idproducto_ser and a.estado = 'P'
                    group by a.fecha,a.idproducto_ser,b.producto
                    order by a.fecha,a.idproducto_ser,b.producto";

    

                $resultado  = $bd->ejecutar($sql);
                $tipo 		= $bd->retorna_tipo();
                
 
                echo '<div class="col-md-12"> ';
                
                $obj->grid->KP_sumatoria(5,"cantidad","total", "","");
                
                $obj->grid->KP_GRID_CTA_query($resultado,$tipo,'Id',$formulario,'S','',$action,'','');
                
                echo '</div> ';

}

if ( $id ==  12 ){
        
        echo '<h4><b>Detalle Diario de Contable de Especies</b></h4>';

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
                      archivo = 'E' and 
                    fecha= ".$bd->sqlvalue_inyeccion($fecha_caja, true)." and
                    estado= ".$bd->sqlvalue_inyeccion('aprobado', true)."  
                    group  by id_asiento, asiento_detalle";

        
        $resultado	= $bd->ejecutar($sql);

            echo '<ul class="list-group">';

            while ($y=$bd->obtener_fila($resultado)){

                $cuenta         = '  <a href="#" title="IMPRIMIR COMPROBANTE DIARIO DE TRANSACCION..." onClick="impresion('.$y['id_asiento'].')">Nro. Asiento: '.trim($y['id_asiento']).'</a> <img src="../../kimages/m_verde.png" align="absmiddle" />  Detalle: '. trim($y['asiento_detalle']);
                
                 
                 

                echo  '<li class="list-group-item"><b>'.  $cuenta.' </b></li>';

                
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

}

?>