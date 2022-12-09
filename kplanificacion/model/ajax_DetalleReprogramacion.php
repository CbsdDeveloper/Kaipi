<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

  
$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$id_sireprogra   = $_GET['id_sireprogra'] ;

$x = $bd->query_array('presupuesto.pre_sireprogramacion',
                                     'estado, tipo', 
                                     'id_sireprogra='.$bd->sqlvalue_inyeccion($id_sireprogra,true)
    );



$sql = ' SELECT id_sirepro_det as id,
                partida ,
                tipo,
                idtarea,
                coalesce(saldo,0) as saldo ,
                coalesce(aumento,0)  as aumento, 
                coalesce(disminuye,0)  as disminuye
                
            
            FROM presupuesto.pre_sireprogramacion_det
            WHERE id_sireprogra ='.$bd->sqlvalue_inyeccion($id_sireprogra, true).'  
            order by id_sirepro_det';
 
echo '<table id="jsontableReforma" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="10%">Partida</th>
    				<th align="center" width="10%">Tipo</th>
                    <th align="center" width="9%">Tarea</th>
    				<th align="center" width="10%">Saldo</th>
    				<th align="center" width="5%">Aumento</th>
                    <th align="center" width="10%">Disminuye</th>                    
                    
                    <th align="center" width="5%">Acciones</th>
    				</tr>
    			</thead>';

       
        $resultado	= $bd->ejecutar($sql);

        while ($y=$bd->obtener_fila($resultado)){
            
            $o = ' onClick="goToURLDel('."'del'".",". $y['id'].','.$id_sireprogra.')" ';
             
            $title1 = 'title="Eliminar Informacion"';
             
            $boton = '<button   class="btn btn-xs" '.$title1.$o.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
               
            $evento =  'onChange="actualiza_datoa('.$y['saldo'].",this.value,". $y['id'].','.$id_sireprogra.')" ';
            
            $evento1 =  'onChange="actualiza_datod('.$y['saldo'].",this.value,". $y['id'].','.$id_sireprogra.')" ';
            
            
            $tipo1='';
            $tipo2='';
            
            echo ' <tr>
				<td>'.$y['partida'].'</td>
                
				<td>'.$y['tipo'].'</td>

 				<td>'.$y['tarea'].'</td>
                
                <td align="right">'.' <input type="number" class="form-control" min="0" max="9999999" step="0.01" readonly value="'.round($y['saldo'],2).'"    id="sa_'.trim($y['id']).'" name="sa_'.trim($y['id']).'">'.'</td>

                <td align="right">'.' <input type="number" '.$evento.$tipo1.' class="form-control" min="-999999999" max="9999999999" step="0.01"  value="'.$y['aumento'].'"   id="au_'.trim($y['id']).'" name="au_'.trim($y['id']).'">'.'</td>

                <td align="right">'.' <input type="number" '.$evento1.$tipo2.'class="form-control" min="-999999999" max="9999999999" step="0.01"  value="'.$y['disminuye'].'"  id="di_'.trim($y['id']).'" name="di_'.trim($y['id']).'">'.'</td>
                <td>'.$boton.  
            '</td> 
                 </tr>'; 
            
        }
       echo	'</table> '; 
        
$div_mistareas = 'ok';

echo $div_mistareas;
?>
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontableReforma').DataTable( {      
                 "searching": true,
                 "paging": true, 
                 "info": true,         
                 "lengthChange":true 
            } );
} );
</script>
  