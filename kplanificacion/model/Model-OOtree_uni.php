<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


 $obj   = 	new objects;

 $bd	   =	new Db;

     $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
     $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];  
     
     $Q_IDPERIODO = $_GET['Q_IDPERIODO'];  
  
     $estado =  EstadoPoa($Q_IDPERIODO ,$bd);
     

     if ( $estado == 0) {
         
         echo '<div class="btn-group">
                    <button type="button" class="btn btn-primary btn-primary" data-toggle="modal" data-target="#myModalIndicador"   onClick="LimpiarPantallaIndicador()">Crear Indicadores</button>
              </div>';
         
     } 
     
echo '<div class="col-md-12" style="padding-top: 15px;padding-bottom: 10px">
        <div class="panel panel-default">
        <div class="panel-body">';
    
          Indicadores($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj);
    
     $UnidadArticula = ' </div></div></div>';
         
     echo $UnidadArticula;

//-----------------------------------------------------------
//--------------------------------------------------------
     function Subnivel($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo){
     	
         $sql1 = 'SELECT  idestrategia_padre
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia_matriz ='.$bd->sqlvalue_inyeccion($codigo,true).' and 
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
                          ' group by idestrategia_padre';
       
        
     	$stmt_nivel2 = $bd->ejecutar($sql1);
     	
        echo '<ul>';
 				       
		while ($y=$bd->obtener_fila($stmt_nivel2)){
				     		
		           $codigo  		= trim($y['idestrategia_padre']);
				   $nombre 		    = Estrategia($bd,$codigo);
				       	
				   echo  '<li> <a href="#"><b>'.$nombre.'</b></a>';
				         Subnivel2($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo);
 				   echo '</li>';
				     		
		 }
		echo '</ul>';
     
     	
     }
   //-------------------------------------
  function Subnivel2( $bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo ){
         
      
      $sql1 = 'SELECT  idestrategia 
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia_padre ='.$bd->sqlvalue_inyeccion($codigo,true).' and
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).
                          ' group by idestrategia';
      
      
      $stmt_nivel2 = $bd->ejecutar($sql1);
      
      echo '<ul>';
      
      while ($y=$bd->obtener_fila($stmt_nivel2)){
          
          $codigo  		= trim($y['idestrategia']);
          $nombre 		    = Estrategia($bd,$codigo);
          
          echo  '<li> <a href="#"><b>'.$nombre.'</b></a>';
             Subnivel3($bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo);
          echo '</li>';
          
      }
      echo '</ul>';
      
         
     }
     //-------------------------------------
     function Subnivel3( $bd,$Q_IDUNIDAD,$Q_IDPERIODO,$codigo ){
         
         
         $sql1 = 'SELECT  idobjetivo,objetivo
					FROM planificacion.view_oe_oo
					WHERE id_departamento = '.$bd->sqlvalue_inyeccion($Q_IDUNIDAD,true).' and
                          idestrategia ='.$bd->sqlvalue_inyeccion($codigo,true).' and
                          anio ='.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true) ;
         
 
         
         $stmt_nivel2 = $bd->ejecutar($sql1);
         
         echo '<ul>';
         
         $imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
         
         while ($y=$bd->obtener_fila($stmt_nivel2)){
             
             $codigo  		    = trim($y['idobjetivo']);
             $nombre 		    =  $imageno .trim($y['objetivo']);
              echo  '<li> <a href="#"><b>'.$nombre.'</b></a></li>';
              
         }
         echo '</ul>';
         
         
     }
     //-----------------------------------------------------------
     //--------------------------------------------------------
     function Estrategia($bd,$id_estrategia){
     	
         $Array = $bd->query_array('planificacion.pyestrategia',
                                   'objetivoe', 
                                   'idestrategia='.$bd->sqlvalue_inyeccion($id_estrategia,true)
             );
         
         
         return $Array['objetivoe'];
 
     }
    
     //-----------------------------------------------------------
     //--------------------------------------------------------
     function Indicadores($id_unidad,$Q_IDPERIODO,$bd,$obj){
   
 
         
     	$sqlOO= 'SELECT   objetivo,   numero,idobjetivo
				FROM planificacion.view_indicadores_oo_res
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND 
					  id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true);

      	
     	$stmt_oo = $bd->ejecutar($sqlOO);
     	
     	echo ' <table class="table table-bordered table-hover">
       		 <thead>
              <tr>
                <th width="25%" >Objetivo</th>
                <th width="20%">Indicador</th>
                <th width="10%">Meta</th>
				<th width="10%">Periodo</th>
                <th width="10%">Formula</th>
                <th width="20%">Medio Verificacion</th>
				<th width="5%"> </th>
            </tr><tbody>';
      
     	while ($y=$bd->obtener_fila($stmt_oo)){
     		Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$y['numero'],$y['idobjetivo']);
     	}
     	echo  ' </tbody></table>';
     	
    
     
     }
     //--------------------------------------------------
     function Indicadores_detalle($id_unidad,$Q_IDPERIODO,$bd,$obj,$nro,$IDOBJETIVO){
     	
     	$sqlOODetalle= 'SELECT    objetivo, indicador,  meta, formula,medio,   periodo,idobjetivoindicador
				FROM planificacion.view_indicadores_oo
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  estado = '.$bd->sqlvalue_inyeccion('S',true).' AND
					  idobjetivo = '.$bd->sqlvalue_inyeccion($IDOBJETIVO,true);
     	
     	
     	
     	
     	$stmtDetalle = $bd->ejecutar($sqlOODetalle);
     	
        $i = 0;
        
     	while ($x=$bd->obtener_fila($stmtDetalle)){
     		
     		$boton ='<button class="btn btn-xs" 
						onClick="goToIndicador('.$x['idobjetivoindicador'].')" data-toggle="modal" data-target="#myModalIndicador" >
					<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
     				
     		
     		$imagen = '<img  align="absmiddle" src="../../kimages/indicadores.png"/> ';
     		
     		$imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
     		
     		if ($nro == 1){ 
     			 echo '<tr>
		                <td>'.$imageno.$x['objetivo'].'</td>
		                <td>'.$imagen.$x['indicador'].'</td>
		                <td>'.$x['meta'].'</td>
		                <td>'.$x['periodo'].'</td>
                         <td>'.$x['formula'].'</td>
                         <td>'.$x['medio'].'</td>
						<td>'.$boton.'</td>
          		      </tr>';
     		}else {
     			if ($i == 0){
     				echo '<tr>
		     				<td rowspan="'.$nro.'">'.$imageno.$x['objetivo'].'</td>
		     				<td>'.$imagen.$x['indicador'].'</td>
		     				<td>'.$x['meta'].'</td>
		     				<td>'.$x['periodo'].'</td>
                            <td>'.$x['formula'].'</td>
                            <td>'.$x['medio'].'</td>
							<td>'.$boton.'</td>
	     				</tr>';
     			}else{
     				echo '<tr>
				                  <td>'.$imagen.$x['indicador'].'</td>
				                  <td>'.$x['meta'].'</td>
				                  <td>'.$x['periodo'].'</td>
                                  <td>'.$x['formula'].'</td>
                                  <td>'.$x['medio'].'</td>
								  <td>'.$boton.'</td>
				            </tr>';
     			}
     		}
     		$i++; 
     	}
      
 
     	
     }
     
     //-------------------------------------------------------------------------------------
     function EstadoPoa( $Q_IDPERIODO ,$bd ){
         
         
         $AUnidad = $bd->query_array('presupuesto.pre_periodo',
             'tipo,estado',
             "tipo in ('elaboracion','proforma') and
			 anio = ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
             );
         
         $valida = 1;
         
         if ( $AUnidad['tipo']  == 'elaboracion'  ){
             $valida = 0;
         }
         
         
         return $valida ;
         
     }
 ?>					 
 
 
 