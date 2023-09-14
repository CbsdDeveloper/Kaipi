<?php

session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

  
$bd	   =	 	new Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

$id_reforma    = $_GET['id_reforma'] ;

$x = $bd->query_array('presupuesto.pre_reforma',
                                     'estado, tipo, tipo_reforma', 
                                     'id_reforma='.$bd->sqlvalue_inyeccion($id_reforma,true)
    );

/*
'Traspaso'    => 'Traspaso',
'Suplemento'    => 'Suplemento',
'Reduccion'    => 'Reduccion'
*/

    if ( trim($x['tipo_reforma']) == 'Traspaso'){
       $cab1 = 'Aumento';
       $cab2 = 'Disminuye';
    }else{
        $cab1 = 'Ingreso';
        $cab2 = 'Gasto';
    }
    

$sql = ' SELECT id_reforma_det as id,
                partida ,
                detalle ,
                actividad ,
                clasificador ,
                fuente ,
                coalesce(saldo,0) as saldo ,
                coalesce(aumento,0)  as aumento, 
                coalesce(disminuye,0)  as disminuye,tipo,
             coalesce(inicial,0) as inicial ,
             coalesce(codificado,0) as codificado ,
             coalesce(reformas,0) as reformas 
 			FROM presupuesto.view_reforma_detalle
			WHERE id_reforma ='.$bd->sqlvalue_inyeccion($id_reforma, true).'  
			order by id_reforma_det';

 
echo '<table id="jsontableReforma" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="10%">Partida</th>
    				<th align="center" width="10%">Detalle</th>
    				<th align="center" width="10%">Clasificador</th>
    				<th align="center" width="5%">Fuente</th>
                    <th align="center" width="10%">Inicial</th>
                    <th align="center" width="9%">Codificado</th>
                    <th align="center" width="8%">Reformas</th>
                    <th align="center" width="8%">Disponible</th>
                    <th align="center" width="15%">'.$cab1.'</th>
                    <th align="center" width="15%">'.$cab2.'</th>
                    <th align="center" width="5%">Acciones</th>
    				</tr>
    			</thead>';

       
        $resultado	= $bd->ejecutar($sql);

        while ($y=$bd->obtener_fila($resultado)){
            
            $o = ' onClick="goToURLDel('."'del'".",". $y['id'].','.$id_reforma.')" ';
             
            $title1 = 'title="Eliminar Informacion"';
             
            $boton = '<button   class="btn btn-xs" '.$title1.$o.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
               
            $evento =  'onChange="actualiza_datoa('.$y['saldo'].",this.value,". $y['id'].','.$id_reforma.')" ';
            
            $evento1 =  'onChange="actualiza_datod('.$y['saldo'].",this.value,". $y['id'].','.$id_reforma.')" ';
            
            if ( trim($x['tipo_reforma']) == 'Traspaso'){
                $tipo1='';
                $tipo2='';
             }else{
                 if ( trim($y['tipo']) == 'I'){
                     $tipo1='';
                     $tipo2=' readonly ';
                 }else{
                     $tipo1=' readonly ';
                     $tipo2='';
                 }
            }
            
            
            echo ' <tr>
				<td>'.$y['partida'].'</td>
				<td><b>'.$y['detalle'].'</b></td>
 				<td>'.$y['clasificador'].'</td>
                <td>'.$y['fuente'].'</td>
                <td><b>'.$y['inicial'].'</b></td>
                <td><b>'.$y['codificado'].'</b></td>
                <td>'.$y['reformas'].'</td>
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
  