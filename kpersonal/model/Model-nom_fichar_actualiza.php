<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
$id_rol = $_GET['id_rol'] ;
$idprov = trim($_GET['idprov']) ;
 

$sql = "SELECT a.id_rold, a.id_periodo, a.idprov, c.nombre, a.ingreso, a.descuento, 
        a.id_rol, a.id_config, coalesce(c.tipo_config,'X') AS tipo 
        FROM nom_rol_pagod a 
        join nom_rol_pagod b on a.id_rol = ".$bd->sqlvalue_inyeccion(  $id_rol , true).' and 
             a.idprov ='.$bd->sqlvalue_inyeccion($idprov, true).'  and 
             a.id_rold = b.id_rold 
        left join view_nomina_rol_reg c on 
             a.id_config = c.id_config_reg order by  a.ingreso desc';

 

$resultado	= $bd->ejecutar($sql);
 
echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="10%">Detalle</th>
                    <th align="center" width="15%">Ingreso</th>
    				<th align="center" width="15%">Descuento</th>
                    </tr>
    			</thead>';



    while ($y=$bd->obtener_fila($resultado)){
        
        $evento =  'onChange="actualiza_dato(1,'.'this.value,'. $y['id_rold'].')" ';
        $evento1 =  'onChange="actualiza_dato(2,'.'this.value,'. $y['id_rold'].')" ';
        
        
        $clased = ' class="form-control" min="-99999999" max="9999999" step="0.01" '. 'id="debe_'.trim($y['id_rold']).'" name="debe_'.trim($y['id_rold']).'"'.' ';
        $claseh = ' class="form-control" min="-99999999" max="9999999" step="0.01" '. 'id="haber_'.trim($y['id_rold']).'" name="haber_'.trim($y['id_rold']).'"'.' ';
        
        if (trim($y['tipo']) == 'I'){
            $read1 = ' ';
            $read2 = ' readonly ';
        }else{
            if (trim($y['tipo']) == 'E'){
                $read1 = ' readonly ';
                $read2 = ' ';
            }else{
                if (trim($y['tipo']) == 'X'){
                    $sqlD = 'DELETE FROM  nom_rol_pagod   WHERE id_rold = '.$bd->sqlvalue_inyeccion($y['id_rold'] ,true);
                    
                    $bd->ejecutar($sqlD);
                    
                }
            }
        }
        
        echo ' <tr>
     				<td>'.$y['nombre'].'</td>
                    <td align="right">'.' <input '.$read1.' type="number" '.$evento.$clased.' value='.'"'.trim($y['ingreso']).'"'.'>'.'</td>
                    <td align="right">'.' <input '.$read2.' type="number" '.$evento1.$claseh.'value='.'"'.trim($y['descuento']).'"'.'>'.'</td>
                     </tr>';
    }
    
    echo	'</table> ';


?>