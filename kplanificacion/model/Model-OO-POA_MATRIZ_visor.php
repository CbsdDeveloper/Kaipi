<?php session_start( );  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
        
 
    $obj   = 	new objects;
 	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];
    
    $Q_IDPERIODO = $_GET['Q_IDPERIODO'];
   
 
    
    echo '<h4><b>3. PLANIFICACION OPERATIVO DE LA UNIDAD</b></h4>';
     
     _Objetivos($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj);
    
    
    
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
     function _Objetivos($id_unidad,$Q_IDPERIODO,$bd,$obj){
    	
 
    	$filsuper  		  = ' class="filasupe" ';
    	$class_actividad  = ' class="actividad" ';
    	
    	//---background-color: lightblue;  style=""
    	
    	//-------------- cabecera de la matriz poa style="padding: 5px"
    	
    	echo ' <div class="ex1"><table   '.$class_actividad.'>
	               <tr '.$filsuper.'>
		                 <th '.$filsuper.' style="text-align: center"   bgcolor="#A5CAE1" width="10%">Objetivo Operativo</th>
 					     <th '.$filsuper.' style="text-align: center"   bgcolor="#A5CAE1" width="90%">

								<table  width="100%"  style="padding: 0px">
   									  <tr>	
											 <th  style="text-align: center"  bgcolor="#A5CAE1"  width="15%">Actividad</th>	
											 <th  style="text-align: center"  bgcolor="#A5CAE1"  width="85%">	
													<table  width="100%"   style="padding: 0px">
														  	<tr>	
																	 <th style="text-align: center" width="23%">Tarea</th>	
                                                                     <th style="text-align: center"  width="20%">Responsable</th>	
																	 <th style="text-align: center"  width="10%">Beneficiarios</th>
                                                                     <th style="text-align: center"  width="12%">Producto</th>		
                                                                     <th style="text-align: center"  width="5%">Aporta a </th>		
                                                                     <th style="text-align: center"  width="10%">Item Presupuestario</th>
																	 <th style="text-align: right"  width="5%">Ene-Abr</th>	
                                                                     <th style="text-align: right" width="5%">May-Ago</th>
                                                                     <th style="text-align: right" width="5%">Sep-Dic</th>
 																	 <th style="text-align: right" width="5%">&nbsp;Total</th>
															</tr>	
													</table>
										      </th>
									  </tr>	
								</table>
					     </th>
                   	</tr> ';
    	
    
    	
    	//-------------- AGREGA OBJETIVOS
    	$total_poa         = 0;
    	$total_actividad   =  0;
    	
    	$sqlOO= 'SELECT  objetivo, idobjetivo,   nro_actividades
					FROM planificacion.view_actividad_poa_res
				WHERE anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true).' AND
					  id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true).' order by objetivo ';
     	
    	$numero    = 0;
    	$stmt_oo   = $bd->ejecutar($sqlOO);
     	$stilo     = ' style="padding: 3px" ';
    	$derecha   = ' class="derecha" ';
    	
     	
    	$imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
    	
    	
    	while ($y=$bd->obtener_fila($stmt_oo)){
    	    
    	    $IDOBJETIVO =  $y['idobjetivo'];
    	    
    	    if ($numero%2==0){
    	        $color =' bgcolor="#f1f1f1" ';
    	    }else{
    	        $color =' bgcolor="#FCFCFC" ';
    	    }
    	    
    	    echo '<tr '.$filsuper.'>';
    	    echo '<td '.$color.' width="15%" '.$derecha.$stilo.' align="left" valign="middle">'.$numero .'. '. $imageno.trim($y['objetivo']).'</td>';
    	    echo '<td '.$color.' width="85%">';

    	    $total_actividad =  _Actividades($IDOBJETIVO,$bd,$obj,$stilo,$derecha);
    	    
    	    echo '<td/>';
    	    echo '</tr>';
    	    
    	    $numero ++;
    	    
    	    $total_poa = $total_poa + $total_actividad;
    	}
 
     
    	
    	echo '  <tr '.$filsuper.'>
		                 <th '.$filsuper.' style="text-align: center"  width="10%"></th>
 					     <th '.$filsuper.' style="text-align: center"  width="90%">
								<table  width="100%"  style="padding: 0px">
   									  <tr>
											 <th  style="text-align: center"  width="10%"> </th>
											 <th  style="text-align: center"  width="90%">
													<table  width="100%"   style="padding: 0px">
														  	<tr>
																	 <th  style="text-align: center"  width="23%"> </th>
																	 <th  style="text-align: center"  width="20%"> </th>
                                                                     <th  style="text-align: center"  width="10%"> </th>
																	 <th  style="text-align: center"  width="12%"> </th>
                                                                     <th  style="text-align: center"  width="5%"> </th>
                                                                     <th  style="text-align: center"  width="10%"> </th>
                                                                     <th  style="text-align: center"  width="5%"> </th>
																	 <th  style="text-align: center"  width="5%"> </th>
																	 <th  style="text-align: center"  width="5%"> TOTAL</th>
																	 <th  style="text-align: right"   width="5%"><h3><b>'.number_format($total_poa,2,",",".").'</b></h3></th>
															</tr>
													</table>
										      </th>
									  </tr>
								</table>
					     </th>
                   	</tr> '; 
    	echo  '</table></div>';
 

    	
 
    }

//---------------------------------------------------------------------------    
    
function _Actividades($IDOBJETIVO,$bd,$obj,$stilo,$derecha){
        
        $tabla_cabecera =  '<table width="100%" class="table1"> ';
        
        $sqlO1= 'SELECT   actividad,   aportaen,    aporte,    idactividad
								   FROM planificacion.view_actividad_poa
				 				  WHERE idobjetivo = '.$bd->sqlvalue_inyeccion($IDOBJETIVO,true).' order by idactividad' ;
        
        $stmt_ac = $bd->ejecutar($sqlO1);
        
        $numero2    = 1;
        
        $total_actividad = 0;
        
        if ($stmt_ac){
            
            echo $tabla_cabecera;
            
             
             while ($x=$bd->obtener_fila($stmt_ac)){
                
                if ($numero2%2==0){
                    $color1 =' bgcolor="#FCFCFC" ';
                }else{
                     $color1 =' bgcolor="#f1f1f1" ';
                }
                 
                $IDACTIVIDAD = $x['idactividad'];
                
                $evento = 'onClick="goToActividad('."'editar'".','.$IDACTIVIDAD.')"';
                
                $nombrea_actividad = '<a  href="#" data-toggle="modal" '.$evento.' data-target="#myModal">'.$numero2.'. '.$x['actividad'].'</a>';
                
                //-------------- AGREGA TAREAS -------------------------------------------------------------
                echo ' <tr>
					<td '.$color1.$derecha.$stilo.'  width="15%">'.$nombrea_actividad.'</td>

 				 	<td '.$color1.' width="85%">';
                
                $total_tarea =  _Tareas($IDACTIVIDAD,$bd,$obj,$stilo,$derecha);
                
                $total_actividad = $total_actividad + $total_tarea;
                
                echo '</td>';
                
                echo '</tr>';
                
                $numero2 ++;
         }
       
        echo '</table>';
        
        return $total_actividad;
        
      }
  }
  //-------------------------
  function _Tareas($IDACTIVIDAD,$bd,$obj,$stilo,$derecha){
      
      $sqlO2= 'SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma, 
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial, 
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen
        FROM planificacion.view_tarea_poa
	  WHERE idactividad = '.$bd->sqlvalue_inyeccion($IDACTIVIDAD,true) ;
      
 
      
      $total_tarea = 0;
      
      $stmt_TA = $bd->ejecutar($sqlO2);
      
      $tabla_cabecera =  '<table width="100%" class="table1"> ';
      
      $imageno = '<img  align="absmiddle" src="../../kimages/oktarea.png"/> ';
      
      if ($stmt_TA){
          
            echo $tabla_cabecera;
            $numero3  = 1;
          
          while ($z=$bd->obtener_fila($stmt_TA)){
              
              if ($numero3%2==0){
                  $color2 =' bgcolor="#f1f1f1" ';
              }else{
                  $color2 =' bgcolor="#FCFCFC" ';
              }
              
              $IDTAREA = $z['idtarea'];
              //-------------------------------------------
              $evento = 'onClick="goToTarea('."'editar'".','.$IDTAREA.')"';
              $nombrea_tarea = '<a  href="#" data-toggle="modal" '.$evento.' data-target="#myModalTarea">'.$imageno.' '.$z['tarea'].'</a>';
              //-------------------------------------------
 
  
              
              echo ' <tr  style="padding: 2px">
						<td '.$color2.$stilo.' width="23%">'.$nombrea_tarea.'</td>
                        <td '.$color2.$stilo.' width="20%">'.trim($z['nombre_funcionario']).'</td>
						<td '.$color2.$stilo.' width="10%">'.$z['beneficiario'].'</td>
                        <td '.$color2.$stilo.' width="12%">'.$z['producto_actividad'].'</td>
                        <td '.$color2.$stilo.' width="5%">'.$z['aportaen'].'</td>
						<td '.$color2.$stilo.' width="10%">'.$z['clasificador'].' '.trim($z['item_presupuestario']).'</td>
	                    <td '.$color2.$stilo.' width="5%"  align="right">'.
						number_format($z['monto1'],2,",",".") .'</td>
 						<td '.$color2.$stilo.' width="5%"  align="right">'.
						number_format($z['monto2'],2,",",".") .'</td>
 	                   <td '.$color2.$stilo.' width="5%"  align="right">'.
						number_format($z['monto3'],2,",",".") .'</td>
 						<td '.$color2.$stilo.' width="10%"  align="right">'.
						number_format($z['inicial'],2,",",".") .'</td>
 						</tr>';
						
						$numero3 ++;
					 
						$total_tarea  = $total_tarea  + $z['inicial'];
          }
          
          echo  '</table>';
      }
      
      return $total_tarea;
  }
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
    function EstadoPoa( $Q_IDPERIODO ,$bd ){
   
        
        $AUnidad = $bd->query_array('presupuesto.pre_periodo',
            'tipo,estado',
            'estado='.$bd->sqlvalue_inyeccion('ejecucion',true). ' and
			 anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)
            );
        
        $valida = 1;
   
        if ( $AUnidad['tipo']  == 'elaboracion'  ){
            $valida = 0;
        }
         
            
     return $valida ;    
    
    }
 
  ?> 
 
 