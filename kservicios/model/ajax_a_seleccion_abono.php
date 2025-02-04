<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   = new Db ;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 
$codigo	         =	$_GET["codigo"];
$estado	         =	$_GET["estado"];
$bandera	     =	$_GET["bandera"];

$accion	     =	$_GET["accion"];


if ($accion == 'datos' ){
    
$EstadoTramite = $bd->query_array('inv_movimiento', 'estado', 'id_movimiento='.$bd->sqlvalue_inyeccion($codigo,true) );
     
if ( trim($EstadoTramite["estado"]) == 'digitado') {
    
    if ($bandera == 'S'){
        
        if ($estado == 'S'){
            
            $sql = "update inv_movimiento
                            set cab_codigo = 1
                            where id_movimiento=".$bd->sqlvalue_inyeccion($codigo, true) ;
            
            $bd->ejecutar($sql);
            
        }else{
            
            
            $sql = "update inv_movimiento
                            set cab_codigo = 0
                            where id_movimiento=".$bd->sqlvalue_inyeccion($codigo, true) ;
            
            $bd->ejecutar($sql);
        }
        
       }
   }
}
//----------------------------------------------------------------------------------------------------------
if ($accion == 'saldos' ){
    
    
    $sql = "SELECT idproducto, producto,
                    sum(monto_iva) as monto_iva,
                    sum(baseiva) as baseiva,
                    sum(tarifa_cero) as tarifa_cero,
                    sum(total) as total
        FROM view_movimiento_det
        where idprov = ".$bd->sqlvalue_inyeccion($codigo, true)." and
              cab_codigo=1 and estado= 'digitado'
        group by  idproducto, producto";
 
    
    
    echo '<table id="jsontableabono" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
                    <th align="center" width="30%">item</th>
    				<th align="center" width="5%">Base Imponible</th>
    				<th align="center" width="5%">Monto IVA</th>
                    <th align="center" width="5%">Tarifa 0</th>
                    <th align="center" width="5%">total</th>
     				<th align="center" width="10%">Base Imponible</th>
    				<th align="center" width="10%">Monto IVA</th>
                    <th align="center" width="10%">Tarifa 0</th>
                    <th align="center" width="10%">Interes</th>
                    <th align="center" width="10%">total</th>
                    </tr>
    			</thead>';
    
    $resultado	= $bd->ejecutar($sql);
    
     
    $n1 = 0;
    $n2 = 0;
    $n3 = 0;
    $n4 = 0;
    
    while ($y=$bd->obtener_fila($resultado)){
        
        $evento =  'onChange="actualiza_datod('."'". $y['idproducto']."'".')" ';
        
        $clase1 = '  class="form-control_asiento" min="-99999999" max="9999999" step="0.01"  value = "0" '. 'id="base_'.trim($y['idproducto']).'" name="base_'.trim($y['idproducto']).'"'.' ';
        $clase2 = '  class="form-control_asiento" min="-99999999" max="9999999" step="0.01" value = "0" '. 'id="iva_'.trim($y['idproducto']).'" name="iva_'.trim($y['idproducto']).'"'.' ';
        $clase3 = '  class="form-control_asiento" min="-99999999" max="9999999" step="0.01" value = "0" '. 'id="base0_'.trim($y['idproducto']).'" name="base0_'.trim($y['idproducto']).'"'.' ';
        $clase4 = '  class="form-control_asiento" min="-99999999" max="9999999" step="0.01" value = "0" '. 'id="interes_'.trim($y['idproducto']).'" name="interes_'.trim($y['idproducto']).'"'.' ';
        $clase5 = '  class="form-control_asiento" min="-99999999" max="9999999" step="0.01" value = "0" '. 'id="total_'.trim($y['idproducto']).'" name="total_'.trim($y['idproducto']).'"'.' ';
        
        echo ' <tr>
 				<td>'.$y['producto'].'</td>
                <td>'.$y['baseiva'].'</td>
                <td>'.$y['monto_iva'].'</td>
                <td>'.$y['tarifa_cero'].'</td>
                <td>'.$y['total'].'</td>
                <td align="right">'.' <input type="number" '.$evento.$clase1.' >'.'</td>
                <td align="right">'.' <input type="number" '.$evento.$clase2.' >'.'</td>
                <td align="right">'.' <input type="number" '.$evento.$clase3.' >'.'</td>
                <td align="right">'.' <input type="number" '.$evento.$clase4.' >'.'</td>
                <td align="right">'.' <input type="number" '.$clase5.' >'.'</td>
                 </tr>';
        
        $n1 = $n1 + $y['baseiva'] ;
        $n2 = $n2 + $y['monto_iva'];
        $n3 = $n3 + $y['tarifa_cero'] ;
        $n4 = $n4 + $y['total'] ;
    }
    
    echo ' <tr>
 				<td> </td>
                <td>'.$n1 .'</td>
                <td>'.$n2 .'</td>
                <td>'.$n3.'</td>
                <td>'.$n4.'</td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right"></td>
                <td align="right"></td>
                 </tr>';
    
    echo	'</table> ';
}




?>
 
  