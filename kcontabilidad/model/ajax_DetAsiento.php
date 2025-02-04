<?php  
session_start();  
 
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
 	
	$bd	   =	 	new Db ;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
     
    $idasiento     = $_GET['id_asiento'] ;
    
    $anio       =  $_SESSION['anio'];
    
    
    $sql = 'SELECT a.cuenta, b.detalle, COALESCE(a.debe,0) as debe, COALESCE(a.haber,0) as haber, 
                   a.aux, a.principal, a.codigo1, a.partida, a.item, a.monto1, a.monto2,a.id_asientod,
                   b.partida_enlace
        FROM public.co_asientod a,  co_plan_ctas b
        where a.id_asiento= '.$bd->sqlvalue_inyeccion($idasiento, true).' and 
              b.cuenta = a.cuenta and b.anio = '.$bd->sqlvalue_inyeccion(  $anio , true).'   
        order by  a.debe desc, a.cuenta';
    
    
    
 
    
    echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
                    <th align="center" width="10%">Acciones</th>
    				<th align="center" width="10%">Cuenta</th>
    				<th align="center" width="30%">Detalle</th>
                    <th align="center" width="15%">Debe</th>
    				<th align="center" width="15%">Haber</th>
    				<th align="center" width="20%">partida</th>
                    </tr>
    			</thead>';
    
    /*
     <a class="btn btn-xs" href="javascript:open_pop('../model/ajax_delAsientosd','action=del&amp;tid=1079&amp;codigo=298',30,30)">
     <i class="icon-trash icon-white"></i></a>
     <a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalAux" onclick="ViewDetAuxiliar(1079)"> ViewDetAuxiliar
     <i class="icon-user icon-white"></i>
     </a><a class="btn btn-xs" href="#" data-toggle="modal" data-target="#myModalCostos" onclick="ViewDetCostos(1079)">
     <i class="icon-asterisk icon-white"></i> Controller-co_xpagar_gasto.php
     </a>
     */
    $resultado	= $bd->ejecutar($sql);
    
    while ($y=$bd->obtener_fila($resultado)){
        
        
        $funcion1  = ' onClick="goToURLDel('."'del'".",". $y['id_asientod'].')" ';
        $title1    = 'title="Eliminar Informacion"';
        $boton_del = '<button   class="btn btn-xs" '.$title1.$funcion1.'   ><i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
        
        
        $boton_gas = '';
        
        if( $y['principal'] == 'S'){
            
            $grupo    = "'".$y['item']."'";
            $partida  = "'".$y['partida']."'";
            $funcion1  = ' onClick="goToURLAsiento('.$y['id_asientod'].','.$y['debe'].','.$y['monto2'].','.$grupo.','.$partida.')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalAsistente" title="Genere asistente de asiento enlace"';
            $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
        }
        
        if( $y['aux'] == 'S'){
            
            $funcion1  = ' onClick="ViewDetAuxiliar('.$y['id_asientod'].')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalAux" title="Genere asistente de asiento enlace"';
            $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-user"></i></button>&nbsp;';
        }
        
        $fondo = '';
        
        if( $y['partida_enlace'] == 'ingreso'){
            $fondo = '  <img src="../../kimages/zingreso.png"/>';
        }
        
        if( $y['partida_enlace'] == 'gasto'){
            $fondo = '  <img src="../../kimages/zgasto.png"/>';
        }
        
        $va = $bd->query_array('co_plan_ctas','credito', 
                                     'cuenta='.$bd->sqlvalue_inyeccion(trim($y['cuenta']),true)." and 
                                      estado=".$bd->sqlvalue_inyeccion('S',true)
            );
        
        $longitud= strlen(trim($va['credito']));
        
        $grupo = '-';
        $boton_ing = '';
        
        if ( $longitud == 2){
            $grupo= trim($va['credito']);
        }
        if ( $longitud == 6){
            $grupo= trim($va['credito']);
        }
        
        if( $grupo <>  '-'){
            
            $funcion1  = ' onClick="PoneEnlace('."'".trim($y['cuenta'])."'".","."'".$grupo."'".')" ';
            $title1    = 'data-toggle="modal" data-target="#myModalAuxIng" title="Asistente de asiento enlace"';
            $boton_ing = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
            
        }
        
        
       
        
        $cuenta  = trim($y['cuenta']);
        $partida = trim($y['partida']);
        $cc = substr($cuenta, 0,3);
        
        $boton_ingreso='';
        
        
        if ( $cc == '113'){
            $funcion1  = ' onClick="CopiaEnlace('."'".trim($y['cuenta'])."'".","."'".$partida."'".')" ';
            $title1    = 'title="Copia cuenta por cobrar enlace"';
            $boton_ingreso = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-paste"></i></button>&nbsp;';
            
        }
        if ( $cc == '124'){
            $funcion1  = ' onClick="CopiaEnlace('."'".trim($y['cuenta'])."'".","."'".$partida."'".')" ';
            $title1    = 'title="Copia cuenta por cobrar enlace"';
            $boton_ingreso = '<button   class="btn btn-xs" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-paste"></i></button>&nbsp;';
            
        }
        
        $acciones = $boton_gas.$boton_del.$boton_ing.$boton_ingreso;
        
        $evento = '';
        $evento1 = '';
        
        $clased = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '. 'id="debe_'.trim($y['id_asientod']).'" name="debe_'.trim($y['id_asientod']).'"'.' ';
        $claseh = ' class="form-control_asiento" min="-99999999" max="9999999" step="0.01" '. 'id="haber_'.trim($y['id_asientod']).'" name="haber_'.trim($y['id_asientod']).'"'.' ';
        
        
        $evento =  'onChange="actualiza_datod('.'this.value,'. $y['id_asientod'].')" ';
        $evento1 =  'onChange="actualiza_datoh('.'this.value,'. $y['id_asientod'].')" ';
        
        
        
        
        
        echo ' <tr>
               <td>'.$acciones.$fondo.'</td>
				<td>'.$cuenta.'</td>
				<td>'.$y['detalle'].'</td>
                <td align="right">'.' <input type="number" '.$evento.$clased.' value='.'"'.trim($y['debe']).'"'.'>'.'</td>
                <td align="right">'.' <input type="number" '.$evento1.$claseh.'value='.'"'.trim($y['haber']).'"'.'>'.'</td>
                <td>'.$y['partida'].'</td>
                 </tr>';
        
    }
    
    //<input type="hidden">
    echo	'</table> ';
    
    $div_mistareas = 'ok';
    
    echo $div_mistareas;
    
  /*   
    $cadena = " || ' ' ";
    
    $sql = ' SELECT a.id_asientod as id,  
                    a.cuenta as "Cuenta", 
                    b.detalle as "Cuenta Detalle",
					coalesce(a.debe,0) as "Debe", 
                    coalesce(a.haber,0) as "Haber", 
                    a.partida '.$cadena.' as "Partida",
                    a.aux
 			FROM co_asientod a, co_plan_ctas b
			WHERE a.cuenta = b.cuenta and 	
				  a.registro = b.registro and 
				  a.registro ='.$bd->sqlvalue_inyeccion($registro, true).' and 
				  a.id_asiento='.$bd->sqlvalue_inyeccion($idasiento, true).' 
			order by a.id_asientod';
	
          $resultado	= $bd->ejecutar($sql);
          
		  $tipo 		= $bd->retorna_tipo();
 		 
		 $enlaceModal    ='myModalAux-myModalCostos';
		 
         $enlace    = '../model/ajax_delAsientosd';
        
         $variables = 'codigo='.$idasiento;
    	
         $obj->grid->KP_GRID_POP_asientos($resultado,$tipo,'id', $enlace,$enlaceModal,$variables,'S','','','del',950,580,''); 
     
         $div_mistareas = 'ok';
      
         echo $div_mistareas;*/
?> 
<script>
 jQuery.noConflict(); 
 
         jQuery(document).ready(function() {
        	jQuery('#jsontableDetalle').DataTable( {      
                 "searching": true,
                 "paging": false, 
                 "info": true,         
                 "lengthChange":false 
            } );
} );
</script>

  