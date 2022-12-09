<?php session_start( );  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
        
 
    $obj   = 	new objects;
 	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
    $Q_IDUNIDAD  = $_GET['Q_IDUNIDAD'];
    
    $Q_IDPERIODO = $_GET['Q_IDPERIODO'];
 
 
    $estado =  EstadoPoa($Q_IDPERIODO ,$bd);
    
 
    
    if ( $estado == 0) {
        
        
     
        echo '<div class="btn-group">
              <button type="button" class="btn btn-primary btn-danger">Objetivos</button>
              <button type="button" class="btn btn-primary btn-info">Indicadores</button>
              <button type="button" class="btn btn-primary btn-primary" data-toggle="modal" data-target="#myModal"   onClick="LimpiarPantalla()"  >Actividades</button>
                      <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                Reportes <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="#"  onClick="ResumenPOA('.$Q_IDUNIDAD.')">Matriz RESUMEN ACTIVIDAD PAPP-POA</a></li>
                                  <li><a href="#" onClick="ResumenPOA_O('.$Q_IDUNIDAD.')"> Matriz RESUMEN OBJETIVOS PAPP-POA</a></li>
                                 <li><a href="#" onClick="ResumenPAPP('.$Q_IDUNIDAD.')"> Matriz PAPP-POA</a></li>
                                </ul>
                      </div>
                <button type="button" class="btn btn-default btn-default" onClick="Notificacion('.$Q_IDUNIDAD.')" title="Notificacion por correo a responsables de tareas"><i class="icon-white icon-bell-alt"></i></button>
            </div>';
        
   
     
    }
	 
    echo '<div class="col-md-12" style="padding: 10px;">';
    
  		   _Objetivos_tarea($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj);
 
   echo '</div>';

    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
     function _Objetivos_tarea($id_unidad,$Q_IDPERIODO,$bd,$obj){
    	
 
    	$filsuper  		  = ' class="filasupe" ';
    	$class_actividad  = ' class="actividad" ';
    	$IDOBJETIVO       = 0;
     
    	
    	$stilo     = 'style="border: 1px solid #AAAAAA; padding: 3px;text-align: center;" ';
    	$derecha   = 'style="padding: 3px;text-align: center;"';
 
    	    
    	echo '<div class="ex1"> 
			     
						  <table '.$class_actividad.' >
   									  <tr>	
											 <th  '.$stilo.'  bgcolor="lightblue" width="20%">Actividad</th>	
											 <th  '.$stilo.'  bgcolor="lightblue" width="80%">	
													<table  width="100%" >
														  	<tr>	
																	 <th '.$derecha.' width="20%">Tarea</th>	
                                                                     <th '.$derecha.' width="15%">Responsable/Ejecuta</th>	
                                                                     <th '.$derecha.' width="15%">Item/Clasificador</th>
																	 <th '.$derecha.' width="10%"> Ene-Mar</th>	
	                                                                 <th '.$derecha.' width="10%"> Abr-Jun</th>	
                                                                     <th '.$derecha.' width="10%"> Jul-Sep</th>
                                                                     <th '.$derecha.' width="10%"> Oct-Dic</th>
 																	 <th '.$derecha.' width="10%"> Total</th>
															</tr>	
													</table>
										      </th>
									  </tr>	
							 ';
    	
    
    	
    	//-------------- AGREGA OBJETIVOS
    	$total_poa         = 0;
    	
    	$total_actividad   =  0;
     	 

    	    $total_actividad =  _Actividades_tarea($IDOBJETIVO,$bd,$obj,$stilo,$derecha,$id_unidad);
    	    
    	  
     	    
    	    $total_poa = $total_poa + $total_actividad;
    	 
 
    	
    	echo '  <tr '.$filsuper.'>
 											 <th  style="text-align: center"  width="20%"> </th>
											 <th  style="text-align: center"  width="80%">
													<table  width="100%"   style="padding: 0px">
														  	<tr>
																	 <th  style="text-align: center"  width="20%"> </th>
																	 <th  style="text-align: center"  width="15%"> </th>
                                                                     <th  style="text-align: center"  width="15%"> </th>
                                                                     <th  style="text-align: center"  width="10%"> </th>
																	 <th  style="text-align: center"  width="10%"> </th>
	                                                                 <th  style="text-align: center"  width="10%"> </th>
																	 <th  style="text-align: center"  width="10%"> TOTAL</th>
																	 <th  style="text-align: right"   width="10%"><h4><b>'.number_format($total_poa,2,",",".").'</b></h4></th>
															</tr>
													</table>
										      </th>
									  </tr> '; 
    	echo  '</table></div>';
 

    	
 
    }
	/*
	*/
	function _Objetivos($id_unidad,$Q_IDPERIODO,$bd,$obj){
    	
 
    	$filsuper  		  = ' class="filasupe" ';
    	$class_actividad  = ' class="actividad" ';
    	
    	//---background-color: lightblue;  style=""
    	//-------------- cabecera de la matriz poa style="padding: 5px"

    	echo '<div class="ex1"> 
			     <table '.$class_actividad.' >
	               <tr '.$filsuper.'>
		                 <th '.$filsuper.' style="text-align: center"   bgcolor="lightblue" width="10%">Objetivo Institucional</th>
 					     <th '.$filsuper.' style="text-align: center"   bgcolor="lightblue" width="90%">

								<table  width="100%">
   									  <tr>	
											 <th  style="text-align: center"  bgcolor="lightblue" width="20%">Actividad</th>	
											 <th  style="text-align: center"   bgcolor="lightblue" width="80%">	
													<table  width="100%"   style="padding: 0px">
														  	<tr>	
																	 <th style="text-align: center;padding: 3px"  width="30%">Tarea</th>	
                                                                     <th style="text-align: center;padding: 3px"  width="20%">Responsable</th>	
                                                                     <th style="text-align: center;padding: 3px"  width="10%">Clasificador</th>
																	 <th style="text-align: right;padding: 3px"   width="10%"> Ene-Abr</th>	
                                                                     <th style="text-align: right;padding: 3px"   width="10%"> May-Ago</th>
                                                                     <th style="text-align: right;padding: 3px"   width="10%"> Sep-Dic</th>
 																	 <th style="text-align: right;padding: 3px"   width="10%"> Total</th>
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

     	$stilo     = ' style="padding: 4px" ';
    	
		 $derecha   = ' class="derecha" ';
    	
     	
    	$imageno = '<img  align="absmiddle" src="../../kimages/oo.png"/> ';
    	
    	
    	while ($y=$bd->obtener_fila($stmt_oo)){
    	    
    	    $IDOBJETIVO =  $y['idobjetivo'];
    	    
    	    if ($numero%2==0){
    	        $color =' bgcolor="#f1f1f1" ';
    	    }else{
    	        $color =' bgcolor="#FCFCFC" ';
    	    }

			$x_o = $bd->query_array('planificacion.view_oe_oo',   // TABLA
			'idestrategia,idestrategia_padre,siglas',                        // CAMPOS
			'idobjetivo='.$bd->sqlvalue_inyeccion( $IDOBJETIVO ,true) // CONDICION
			);

			$x_i = $bd->query_array('planificacion.pyestrategia',   // TABLA
			'siglas',                        // CAMPOS
			'idestrategia='.$bd->sqlvalue_inyeccion( $x_o['idestrategia_padre'] ,true) // CONDICION
			);

			$objetivo_dato = trim($x_i['siglas']).' | '.trim($x_o['siglas']).' '. $imageno.trim($y['objetivo']);
    	    
    	    echo '<tr '.$filsuper.'>';
    	    echo '<td '.$color.' width="10%" '.$derecha.$stilo.' align="left" valign="middle"><b>'. $objetivo_dato .'</b></td>';
    	    echo '<td '.$color.' width="90%">';

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
											 <th  style="text-align: center"  width="20%"> </th>
											 <th  style="text-align: center"  width="80%">
													<table  width="100%"   style="padding: 0px">
														  	<tr>
																	 <th  style="text-align: center"  width="30%"> </th>
																	 <th  style="text-align: center"  width="20%"> </th>
                                                                     <th  style="text-align: center"  width="10%"> </th>
                                                                     <th  style="text-align: center"  width="10%"> </th>
																	 <th  style="text-align: center"  width="10%"> </th>
																	 <th  style="text-align: center"  width="10%"> TOTAL</th>
																	 <th  style="text-align: right"   width="10%"><h6>'.number_format($total_poa,2,",",".").'</h6></th>
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
        
        $sqlO1="SELECT   actividad,   aportaen,    aporte,    idactividad
								   FROM planificacion.view_actividad_poa
				 				  WHERE  estado = 'S' and idobjetivo = ".$bd->sqlvalue_inyeccion($IDOBJETIVO,true).' order by idactividad' ;
        
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
                 
                $IDACTIVIDAD 		= $x['idactividad'];
                
                $evento 		    = 'onClick="goToActividad('."'editar'".','.$IDACTIVIDAD.')"';
                
                $nombrea_actividad  = '<a  href="#" data-toggle="modal" '.$evento.' data-target="#myModal">'.$numero2.'. '.$x['actividad'].'</a>';
                
				$boton_tarea = '<button type="button"
								class="btn btn-default btn-xs"
								onClick="LimpiarPantallaTarea('.$IDACTIVIDAD .')"
								data-toggle="modal"
								data-target="#myModalTarea"
								title="Crear Tarea">
								<i class="icon-white icon-plus"> </i>  
							</button> ';

                //-------------- AGREGA TAREAS -------------------------------------------------------------
                echo ' <tr>
					<td '.$color1.$derecha.$stilo.'  width="20%"><b>'.$boton_tarea.$nombrea_actividad .'</b></td>

 				 	<td '.$color1.' width="80%">';
                
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
  /*
  */
  function _Actividades_tarea($IDOBJETIVO,$bd,$obj,$stilo,$derecha,$id_unidad){
        



 
	$sqlO1= 'SELECT   actividad,    idactividad
							   FROM planificacion.view_actividad_poa
							   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true)." and  estado = 'S' 
									   group by actividad,    idactividad 
									   order by actividad" ;
	
	$stmt_ac = $bd->ejecutar($sqlO1);
	
	$numero2    = 1;
	
	$total_actividad = 0;
	
	if ($stmt_ac){
		
	
		 
		 while ($x=$bd->obtener_fila($stmt_ac)){
			
			if ($numero2%2==0){
				$color1 =' bgcolor="#FCFCFC" ';
			}else{
				 $color1 =' bgcolor="#f1f1f1" ';
			}
			 
			$IDACTIVIDAD 		= $x['idactividad'];
			
			$evento 		    = 'onClick="goToActividad('."'editar'".','.$IDACTIVIDAD.')"';
			
			$nombrea_actividad  = '<a  href="#" data-toggle="modal" '.$evento.' data-target="#myModal">'.$numero2.'. '.$x['actividad'].'</a>';
			
			$boton_tarea = '<button type="button"
							class="btn btn-default btn-xs"
							onClick="LimpiarPantallaTarea('.$IDACTIVIDAD .')"
							data-toggle="modal"
							data-target="#myModalTarea"
							title="Crear Tarea">
							<i class="icon-white icon-plus"> </i>  
						</button> ';

		 $stilo1     = ' style="padding: 15px" ';
			//-------------- AGREGA TAREAS -------------------------------------------------------------
			echo ' <tr>
				<td '.$color1.$derecha.$stilo1.'  width="20%">&nbsp; <b> '.$boton_tarea.$nombrea_actividad .'</b></td>

				  <td '.$color1.' width="80%">';
			
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
      
      $sqlO2= "SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma, 
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial, 
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen,monto4
        FROM planificacion.view_tarea_poa
	  WHERE estado = 'S' and idactividad = ".$bd->sqlvalue_inyeccion($IDACTIVIDAD,true) ;
      
 
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
 
			  $stilo     = 'style="border: 1px solid #AAAAAA; padding: 4px;" ';
			  
			  if ($z['clasificador'] == '-'){
			      $detallef = 'No Aplica';
			  }else{
			      $detallef = trim($z['clasificador']).' '.trim($z['item_presupuestario']);
			  }
             
              echo ' <tr  style="padding: 2px">
						<td '.$color2.$stilo.' width="20%">'.$nombrea_tarea.'</td>
                        <td '.$color2.$stilo.' width="15%">'.trim($z['nombre_funcionario']).'</td>
 						<td '.$color2.$stilo.' width="15%"  align="left" title= "'. trim($z['item_presupuestario']).'">'.  $detallef.'</td>
	                    <td '.$color2.$stilo.' width="10%"  align="right">'. number_format($z['monto1'],2,",",".") .'</td>
 						<td '.$color2.$stilo.' width="10%"  align="right">'. number_format($z['monto2'],2,",",".") .'</td>
 	                    <td '.$color2.$stilo.' width="10%"  align="right">'. number_format($z['monto3'],2,",",".") .'</td>
                         <td '.$color2.$stilo.' width="10%"  align="right">'. number_format($z['monto4'],2,",",".") .'</td>
 						<td '.$color2.$stilo.' width="10%"  align="right">'. number_format($z['inicial'],2,",",".") .'</td>
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
								
 
 
 