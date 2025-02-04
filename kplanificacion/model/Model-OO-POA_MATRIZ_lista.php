<?php session_start( );  
   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/  
	require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
        
 
    $obj   = 	new objects;
 	$bd	   =	new Db;
    
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
    $Q_IDUNIDAD = $_GET['Q_IDUNIDAD'];
    
    $Q_IDPERIODO = $_GET['Q_IDPERIODO'];
   
 
    
  //  echo '<h4><b>3. PLANIFICACION OPERATIVO DE LA UNIDAD</b></h4>';
     
 

    _Lista_tarea($Q_IDUNIDAD,$Q_IDPERIODO,$bd,$obj) ;
    
    
    
    //-------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------
     function _Lista_tarea($id_unidad,$Q_IDPERIODO,$bd,$obj){
    	

        $x = $bd->query_array('nom_departamento',   // TABLA
        'nombre',                        // CAMPOS
        'id_departamento='.$bd->sqlvalue_inyeccion( $id_unidad,true) // CONDICION
);


 

        echo '<H5>PLANIFICACION OPERATIVA ANUAL</br> <b>Unidad: '. $x['nombre'].'</br>Perido: '.$Q_IDPERIODO.' </b></H5>';
  
        $tabla_cabecera =  '<table width="100%" class="table1"> ';

        $stilo = ' class="filasupe" ';

        echo   $tabla_cabecera.'
        <tr>	
               <th class="filasupe"  width="5%">Nro.</th>	
               <th class="filasupe"  width="10%">Programa</th>	
               <th class="filasupe"  width="10%">Clasificador</th>
               <th class="filasupe"  width="30%">Tarea/Ejecuta</th>		
               <th class="filasupe"  width="5%">Recurso? </th>		
               <th class="filasupe"  width="20%">Responsable</th>		
               <th class="filasupe"  width="5%">Enlace PAC</th>
               <th class="filasupe"   width="5%">Inicial</th>	
               <th class="filasupe"   width="5%">Codificado</th>
               <th class="filasupe"  width="5%">Ejecutado</th>
                <th class="filasupe"  width="5%">Disponible</th>
      </tr>';


      $sqlO2= 'select programa, clasificador,tarea, recurso,nombre_funcionario,enlace_pac,inicial,codificado ,ejecutado,disponible
                from planificacion.view_tarea_poa
                where id_departamento  = '.$bd->sqlvalue_inyeccion($id_unidad,true) .'
                and anio = '.$bd->sqlvalue_inyeccion($Q_IDPERIODO,true) ;
                    
                $stmt_TA = $bd->ejecutar($sqlO2);
      
                $numero3  = 1;

                $total_tarea1  = 0;
                $total_tarea2  = 0;
                $total_tarea3  = 0;
                $total_tarea4  = 0;
                    
                    while ($z=$bd->obtener_fila($stmt_TA)){
                        
                        if ($numero3%2==0){
                            $color2 =' bgcolor="#f1f1f1" ';
                        }else{
                            $color2 =' bgcolor="#FCFCFC" ';
                        }
                        
                        if ( empty($z['enlace_pac'])){
                            $pac ='N';
                        }else{
                            $pac ='S';
                        }
            
                        echo ' <tr  style="padding: 2px">
                                  <td '.$color2.$stilo.'>'. $numero3 .'</td>
                                  <td '.$color2.$stilo.'>'.trim($z['programa']).'</td>
                                  <td '.$color2.$stilo.'>'.trim($z['clasificador']).'</td>
                                  <td '.$color2.$stilo.'>'.trim($z['tarea']).'</td>
                                  <td '.$color2.$stilo.'>'.trim($z['recurso']).'</td>
                                  <td '.$color2.$stilo.'>'.trim($z['nombre_funcionario']).'</td>
                                  <td '.$color2.$stilo.'>'.trim($pac).'</td>
                                  <td '.$color2.$stilo.' align="right">'.
                                  number_format($z['inicial'],2,",",".") .'</td>
                                  <td '.$color2.$stilo.' align="right">'.
                                  number_format($z['codificado'],2,",",".") .'</td>
                                  <td '.$color2.$stilo.' align="right">'.
                                  number_format($z['ejecutado'],2,",",".") .'</td>
                                  <td '.$color2.$stilo.' align="right">'.
                                  number_format($z['disponible'],2,",",".") .'</td>
                                   </tr>';
                                  
                                  $numero3 ++;
                               
                                  $total_tarea1  = $total_tarea1  + $z['inicial'];
                                  $total_tarea2  = $total_tarea2  + $z['codificado'];
                                  $total_tarea3  = $total_tarea3  + $z['ejecutado'];
                                  $total_tarea4  = $total_tarea4  + $z['disponible'];
                    }
                    

                    echo ' <tr  style="padding: 2px">
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'> </td>
                    <td '.$color2.$stilo.'>  </td>
                    <td '.$color2.$stilo.' align="right">'.
                    number_format($total_tarea1,2,",",".") .'</td>
                    <td '.$color2.$stilo.' align="right">'.
                    number_format($total_tarea2,2,",",".") .'</td>
                    <td '.$color2.$stilo.' align="right">'.
                    number_format($total_tarea3,2,",",".") .'</td>
                    <td '.$color2.$stilo.' align="right">'.
                    number_format($total_tarea4,2,",",".") .'</td>
                     </tr>';

                    echo  '</table>';
             
 
 
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
 
 