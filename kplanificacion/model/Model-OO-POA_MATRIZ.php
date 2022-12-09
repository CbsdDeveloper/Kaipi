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
               <button type="button" class="btn btn-primary btn-primary" data-toggle="modal" data-target="#myModal"   onClick="LimpiarPantalla()"  >Actividades</button>
              <button type="button" class="btn btn-info btn-info" onClick="RefrescaMatriz()" title="Refrescar Matriz"><i class="icon-white icon-asterisk"></i></button>
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
        
   
     
    }else {
        echo '<div class="btn-group">
              <button type="button" class="btn btn-info btn-info" onClick="RefrescaMatriz()" title="Refrescar Matriz"><i class="icon-white icon-asterisk"></i></button>
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
	 
    echo '<div class="col-md-12" style="padding-top: 15px;padding-bottom: 10px">';
    
  		   _Objetivos_tarea($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj);
 
   echo '</div>';

    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
     function _Objetivos_tarea($id_unidad,$Q_IDPERIODO,$bd,$obj){
    	
 
   
    	$class_actividad  = ' class="actividad" ';
    	$IDOBJETIVO       = 0;
     
    	
    	$stilo     = 'style="border: 1px solid #99bdcf; padding: 5px;text-align: center;" ';
    	$derecha   = 'style="padding: 3px;text-align: center;"';
 
    	    
    	echo '<div class="ex1"> 
                <table '.$class_actividad.' >
                  <tbody>
                    <tr>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">CODIGO</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="20%">TAREA</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="15%">RESPONSABLE/TAREA</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="15%">PRODUCTO</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="20%">ITEM/CLASIFICADOR</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">ENE-MAR</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">ABR-JUN</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">JUL-SEP</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">OCT-DIC</td>
                      <td '.$stilo.'  bgcolor="lightblue" width="5%">TOTAL</td>
                    </tr>
                    <tr>
                      <td colspan="10">&nbsp;</td>
                    </tr> ';
    	
    
    	
    	//-------------- AGREGA OBJETIVOS
    	  $total_poa         =  0;
    	  $total_actividad   =  0;
     	  $total_actividad   =  _Actividades_tarea($IDOBJETIVO,$bd,$obj,$stilo,$derecha,$id_unidad);
    	    
    	  
     	    
    	    $total_poa = $total_poa + $total_actividad;
    	    
     	    $stilo     = 'style="padding:10px;text-align: right;font-size: 12px;font-weight:bold" ';
    	    
    	    echo '<tr><td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="padding:10px;font-size: 12px;font-weight:bold">RESUMEN</td>
                      <td '.$stilo.' align="right">'. number_format($total_actividad,2,",",".") .'</td>
                    </tr>';
  
    	echo  '</table></div>';
 
    	
    	
    	
 
    }
   /*
  */
  function _Actividades_tarea($IDOBJETIVO,$bd,$obj,$stilo,$derecha,$id_unidad){
        
 

 
	$sqlO1= 'SELECT   actividad,    idactividad
							   FROM planificacion.view_actividad_poa
							   WHERE id_departamento = '.$bd->sqlvalue_inyeccion($id_unidad,true)." and  estado = 'S' 
									   group by actividad,    idactividad 
									   order by actividad desc" ;
	
	$stmt_ac = $bd->ejecutar($sqlO1);
	
	$numero2    = 1;
	
	$total_actividad = 0;
	
	if ($stmt_ac){
		
	    $stilo     = 'style="border: 1px solid #d3cdcd; padding: 3px;font-weight:550;" ';
	    
	    $stilo_a   = ' style="padding: 6px;" ';
	    
	    
		 
		 while ($x=$bd->obtener_fila($stmt_ac)){
			
			if ($numero2%2==0){
				 $color1 =' bgcolor="#FCFCFC" ';
			}else{
				 $color1 =' bgcolor="#f1f1f1" ';
			}
			 
			$IDACTIVIDAD 		= $x['idactividad'];
			$evento 		    = 'onClick="goToActividad('."'editar'".','.$IDACTIVIDAD.')"';
			$nombrea_actividad  = '<a  href="#" data-toggle="modal" '.$evento.' data-target="#myModal">'.'A-'.$numero2.'. '.strtoupper(trim($x['actividad'])).'</a>';
			
			$boton_tarea = '<button type="button"
							class="btn btn-default btn-xs"
							onClick="LimpiarPantallaTarea('.$IDACTIVIDAD .')"
							data-toggle="modal"
							data-target="#myModalTarea"
							title="Crear Tarea">
							<i class="icon-white icon-plus"> </i>
						</button> ';
			
			
			echo '<tr>
        			<td '.$color1 .$stilo_a.'  colspan="10">'.$boton_tarea.$nombrea_actividad. '</td>
        		 </tr>';
			
		 
			$total_tarea =  _Tareas($IDACTIVIDAD,$bd,$obj,$stilo,$numero2);
			 
			$total_actividad = $total_actividad + $total_tarea;
		 
			$numero2 ++;
	 }
   

	
	 return $total_actividad;
	
  }
}
  //-------------------------
function _Tareas($IDACTIVIDAD,$bd,$obj,$stilo,$numero2){
      
      $sqlO2= "SELECT   idtarea, idactividad, estado, tarea, recurso, inicial,
                       codificado, certificacion, ejecutado, disponible, aumentoreformas, disminuyereforma, 
                       cumplimiento, reprogramacion, responsable, nombre_funcionario, correo, movil, fechainicial, 
                       fechafinal, sesion, creacion, sesionm, modificacion, programa, clasificador, item_presupuestario,
                        pac, actividad, fuente, producto, monto1,monto2,monto3,beneficiario, producto_actividad, aportaen,monto4
        FROM planificacion.view_tarea_poa
	  WHERE estado = 'S' and idactividad = ".$bd->sqlvalue_inyeccion($IDACTIVIDAD,true) ;
      
      
      $total_tarea = 0;
      
      $stmt_TA = $bd->ejecutar($sqlO2);
      
       
      
      if ($stmt_TA){
          
          $numero3  = 1;
          
          while ($z=$bd->obtener_fila($stmt_TA)){
                      
                      if ($numero3%2==0){
                          $color2 =' bgcolor="#f1f1f1" ';
                      }else{
                          $color2 =' bgcolor="#FCFCFC" ';
                      }
                      
                      $IDTAREA = $z['idtarea'];
                      
                      $evento        = 'onClick="goToTarea('."'editar'".','.$IDTAREA.')"';
                      $nombrea_tarea = '<a   style="color: #252525" href="#" data-toggle="modal" '.$evento.' data-target="#myModalTarea">'.$z['tarea'].'</a>';
                      
                      $len = strlen( trim($z['clasificador']));
                      
                      if ( $len < 5 ){
                          $detallef = 'Gestion Sin Recurso';
                      }else{
                          $detallef = trim($z['clasificador']).' '.trim($z['item_presupuestario']);
                      }
                      
                      $secuencia = 'A.'.$numero2.'.'.$numero3;
                      echo ' <tr> 
                                <td '.$color2.$stilo.'>'.$secuencia.'</td> 
                                <td '.$color2.$stilo.'>'.$nombrea_tarea.'</td> 
                                <td '.$color2.$stilo.'>'.trim($z['nombre_funcionario']).'</td>
                                <td '.$color2.$stilo.'>'.trim($z['producto_actividad']).'</td>
                                <td '.$color2.$stilo.' align="left" title= "'. trim($z['item_presupuestario']).'">'.  $detallef.'</td>
                                <td '.$color2.$stilo.' align="right">'. number_format($z['monto1'],2,",",".") .'</td>
 						        <td '.$color2.$stilo.' align="right">'. number_format($z['monto2'],2,",",".") .'</td>
 	                            <td '.$color2.$stilo.' align="right">'. number_format($z['monto3'],2,",",".") .'</td>
                                <td '.$color2.$stilo.' align="right">'. number_format($z['monto4'],2,",",".") .'</td>
 						        <td '.$color2.$stilo.' align="right">'. number_format($z['inicial'],2,",",".") .'</td>';
                      echo ' </tr>';
              
                      $numero3 ++;
                      
                      $total_tarea  = $total_tarea  + $z['inicial'];
          }
          
          
             echo '<tr><td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td '.$stilo.' align="right">'. number_format($total_tarea,2,",",".") .'</td>
                    </tr>';
          
      }
      
       
      
      return $total_tarea;
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
								
 
 
 