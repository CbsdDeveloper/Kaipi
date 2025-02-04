<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery(' #fo21').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#guardarTarea').html(data);
            
			}
        })        
        return false;
    }); 
 })
</script>	
 
  
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
    
 
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date("Y-m-d");
                
                $this->usuario 	 =  trim($_SESSION['usuario']);
        
        
      }
 //---------------------------------------------------------------------  
      function Formulario( $idproceso,$idtarea){
      
                $tipo = $this->bd->retorna_tipo();
           	    
     		    $flujo = $this->bd->query_array('flow.wk_procesoflujo',
     		    		'tarea,original,condicion,siguiente,anterior',
     		    		'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
                        idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea,true)
     		    		);
     		    
     		    $datos['condicion'] = $flujo['condicion'];
     		    $datos['siguiente'] = $flujo['siguiente'];
     		    $datos['anterior']  = $flujo['anterior'];
     		    
     		    $this->set->div_label(12,'<h4><b>'.$flujo['tarea'] .'</b></h4>');
     		 
     		    $sqlDepa = "SELECT idproceso, idproceso_var, variable 
									  FROM flow.wk_proceso_variables
									  where estado = 'S' AND 
                                            idproceso = ".$this->bd->sqlvalue_inyeccion($idproceso,true). " order by orden";
									     		       
     		    $stmt_depa= $this->bd->ejecutar($sqlDepa);
     		       
     		    while ($x=$this->bd->obtener_fila($stmt_depa)){
     		       	
					     		       	$variable = trim($x['variable']);
					     		       	$idproceso_var  =  $x['idproceso_var'];
					     		       
					     		       	$op = 'op_'.$x['idproceso_var'];
					     		       	
					     		       	$idop1 = 'op_'.$x['idproceso_var'].'_0';
					     		       	$idop2 = 'op_'.$x['idproceso_var'].'_1';
					     		       	$idop3 = 'op_'.$x['idproceso_var'].'_2';
 					      		       	
					     		       	echo   '<div class="col-md-3" style="padding: 3px">'.$variable.' </div><div class="col-md-9" style="padding: 3px">
					 								 <label class="radio-inline"><input type="radio" name="'.	$op.'" id="'.$idop1.'" value="0">Ninguno</label>
								     		        <label class="radio-inline"><input type="radio" name="'.	$op.'" id="'.$idop2.'" value="1">Lectura</label>
												    <label class="radio-inline"><input type="radio" name="'.	$op.'" id="'.$idop3.'" value="2">Escitura</label>
								     		       </label>
											</div>';
     		       	
					     		       	$this->asignar($idproceso, $idproceso_var,$idtarea,$op);
     		       }
      		       
     		       $this->set->div_label(12,'<h5> Parametros de Proceso <h5>');
     		    
     		       $datos['tarea'] = $flujo['tarea'];
     		       
     		       $this->obj->text->text_yellow('Tarea',"texto",'tarea',150,150,$datos,'required','','div-3-9') ;
     		       
     		       $evento = ' onchange="valida_condicion(this.value)" ';
     		       
     		       $MATRIZ = array(
     		       		'N'    => 'NO',
     		       		'S'    => 'SI',
      		       );
     		       
     		       $this->obj->list->listae('Es Condicion?',$MATRIZ,'condicion',$datos,'required','',$evento,'div-3-9');
     		       
			     		    	
     		       $proximo = $idtarea + 1 ;
     		       
     		       $sqlb = " SELECT    idtarea  AS CODIGO, tarea AS NOMBRE
									  FROM flow.wk_procesoflujo
									  WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($proximo ,true)."  AND 
                                            idproceso = ".$idproceso.' order by idtarea';
     		       
     		       $resultado = $this->bd->ejecutar($sqlb);
     		       
      		       
     		       $this->obj->list->listadb($resultado,$tipo,'Proxima','siguiente',$datos,'','','div-3-9');
      		    
     		       //----------------------------------------
      		       $sqlb = " SELECT    idtarea  AS CODIGO, tarea AS NOMBRE
							   FROM flow.wk_procesoflujo
							  WHERE  LENGTH(tarea) > 2 and 
                                    idtarea <>   ".$this->bd->sqlvalue_inyeccion($idtarea,true)."  AND 
                                    idproceso = ".$idproceso.' order by idtarea';
     		       
     		       $resultado = $this->bd->ejecutar($sqlb);
      	 	       
     		       $this->obj->list->listadb($resultado,$tipo,'','anterior',$datos,'required','disabled','div-3-9');
 
                   $datos['procesoid'] =  $idproceso;
                   
     		       $datos['tareaid'] =  $idtarea;
     		       
     		       $this->obj->text->texto_oculto("procesoid",$datos); 
      		       
     		       $this->obj->text->texto_oculto("tareaid",$datos); 
     		       
   }
 
   //----------------------------------------------
  //----------------------------------------------
   function asignar($idproceso, $idproceso_var,$idtarea,$op){
 
   	$flujo = $this->bd->query_array('flow.wk_proceso_formulario',
   			'acceso',
   			'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea,true). ' and 
            idproceso_var = '.$this->bd->sqlvalue_inyeccion($idproceso_var,true)
   			);
   	
   	  
    	$idop_opcion  = $op.'_'.$flujo['acceso'];
  
    	$squery = "$('#".$idop_opcion."').attr('checked', 'checked');";
   	
    	echo '<script>'.$squery.'</script>';
   	
  }  
  //----------------------------------------------
  function tabDatos($idproceso,$id ){
      
     
      
     echo '<ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#home">Formulario</a></li>
                <li><a data-toggle="pill" href="#menu0">Control Tiempo</a></li>
                <li><a data-toggle="pill" href="#menu1">Responsables</a></li>
                <li><a data-toggle="pill" href="#menu2">Requisitos</a></li>
                <li><a data-toggle="pill" href="#menu3">Documentos</a></li>
           </ul>
   <div class="tab-content">
        <div id="home" class="tab-pane fade in active"> ';
         $this->Formulario( $idproceso,$id);
   echo '</div>
   <div id="menu0" class="tab-pane fade">';
         $this->notificacion($idproceso,$id);
     
   echo '</div>
      <div id="menu1" class="tab-pane fade">';
     $this->departamento_responsable($idproceso,$id);
   echo '</div>

    <div id="menu2" class="tab-pane fade">';
    $this->requisitos_proceso($idproceso,$id);
      
   echo ' </div>

    <div id="menu3" class="tab-pane fade">';
   $this->documento_proceso($idproceso,$id);
   echo '</div>

  </div>';
      
  } 
  //----------------------------------------------
  function departamento_responsable( $idproceso,$idtarea){
      
      $tipo = $this->bd->retorna_tipo();
      
      
      $datos = array();
      
   
      $this->set->div_label(12,'<h5> Asignar unidad operativa<h5>');
      
      
      $sqlb = "SELECT '0' AS codigo, ' - 0.- Aplica a Todos - ' as nombre union 
             SELECT codigo, nombre FROM flow.view_unidadProceso union
             SELECT '1' AS codigo, ' - 1.-  Aplica a Responsables - ' as nombre 
             ORDER BY 2" ;
                  
 
      
      $resultado = $this->bd->ejecutar($sqlb);
      
      $this->obj->list->listadb($resultado,$tipo,'Unidad','unidad',$datos,'required','','div-1-5');
      
      $MATRIZ = array(
            'publico'    => 'Publico'
      );
      
      $evento ='';
      $this->obj->list->listae('Ambito',$MATRIZ,'ambito_proceso',$datos,'required','',$evento,'div-1-5');
      
      
      $MATRIZ = array(
          '-'    => '-',
          'S'    => 'Si',
          'N'    => 'No'
      );
     
      $this->obj->list->listae('Reasignar?',$MATRIZ,'reasignar',$datos,'required','',$evento,'div-1-5');
      
     
      
      $MATRIZ = array(
          '-'    => ' [ Seleccione Perfil para la tarea ] ',
           'operador'    => 'Operador' 
       );
      
      
      $evento = ' onChange="GuardaResponsable('.$idproceso.','.$idtarea.');"';
      
      $this->obj->list->listae('Perfil',$MATRIZ,'perfil',$datos,'required','',$evento,'div-1-5');
     
      $this->set->div_label(12,'<h5> Unidad Responsable<h5>');
      
      echo '<div id="UnidadTarea1">DETALLE</div>';
      
      echo '<div id="GuardaUnidadTarea"></div>';
      
  } 
  //----------------------------------------------
  function requisitos_proceso($idproceso,$idtarea ){
      
   
      $this->set->div_label(12,'<h5> Requisitos <h5>');
      
      
      $sqlb = " SELECT  idproceso_requi  , requisito 
				 FROM flow.wk_proceso_requisitos
                WHERE estado = 'S' and idproceso=".$idproceso.' order by requisito'  ;
      
      $stmt_depa= $this->bd->ejecutar($sqlb);
       
 
      echo ' <table id="table_cheque" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
				<th width="15%">Requisito</th>
				<th width="10%">Operador</th>
                <th width="10%">Observador</th>
				</tr>
			</thead>';
      
      while ($x=$this->bd->obtener_fila($stmt_depa)){
          
           $cnombre          =  trim($x['requisito']);
           $idproceso_requi  =  $x['idproceso_requi'];
          
 
           $xx = $this->bd->query_array('flow.wk_proceso_formulario_requi',
               'requisito_perfil',
               'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
                                         idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true).' and
                                         idproceso_requi='.$this->bd->sqlvalue_inyeccion($idproceso_requi,true)
               );
           
           $requesito          =  trim($xx['requisito_perfil']);
           
          $ncheck1 = 'id = "operador'.$idproceso_requi.'"';
          $ncheck2 = 'id = "observador'.$idproceso_requi.'"';
          
          $check1 =' ';
          $check2 =' ';
          if ( $requesito == 'operador'){
              $check1 ='checked';
              $check2 =' ';
          }
          
          if ( $requesito == 'observador'){
              $check1 =' ';
              $check2 ='checked';
          }
          
   
          
          $bandera1 = '<input type="checkbox" '.$ncheck1.' onclick="GuardaRequisitos(1,'.$idproceso.','.$idtarea.','.$x['idproceso_requi'].',this)" '.$check1.'> ';
          
          $bandera2 = '<input type="checkbox" '.$ncheck2.' onclick="GuardaRequisitos(2,'.$idproceso.','.$idtarea.','.$x['idproceso_requi'].',this)" '.$check2.'> ';
           
          echo ' <tr>
				<td>'.$cnombre.'</td>
				<td>'.$bandera1.'</td>
                <td>'.$bandera2.'</td>
				</tr>';
          
      }
      
      echo	'</table>';
      
          
           
      
    
      
  } 
  //----------------------------------------------
  function documento_proceso($idproceso,$idtarea ){
      
       
       
      $this->set->div_label(12,'<h5> Emision de documentos<h5>');
      
      
      $sqlb = " SELECT  idproceso_docu, documento 
				 FROM flow.wk_proceso_documento
                WHERE estado = 'S' and idproceso=".$idproceso. ' order by documento';
      
      $stmt_depa= $this->bd->ejecutar($sqlb);
      
      
      echo ' <table id="table_doc" class="table table-hover datatable" cellspacing="0" width="100%" style="font-size: 11px"  >
			<thead>
			 <tr>
				<th width="15%">Documento</th>
				<th width="10%">Operador</th>
                <th width="10%">Observador</th>
				</tr>
			</thead>';
      
      while ($x=$this->bd->obtener_fila($stmt_depa)){
          
          $cnombre          =  trim($x['documento']);
          $idproceso_requi  =  $x['idproceso_docu'];
          
          
          $xx = $this->bd->query_array('flow.wk_proceso_formulario_doc',
              'perfil_documento',
              'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
                                         idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true).' and
                                         idproceso_docu='.$this->bd->sqlvalue_inyeccion($idproceso_requi,true)
              );
          
          $requesito          =  trim($xx['perfil_documento']);
          
          $ncheck1 = 'id = "doperador'.$idproceso_requi.'"';
          $ncheck2 = 'id = "dobservador'.$idproceso_requi.'"';
          
          $check1 =' ';
          $check2 =' ';
          if ( $requesito == 'operador'){
              $check1 ='checked';
              $check2 =' ';
          }
          
          if ( $requesito == 'observador'){
              $check1 =' ';
              $check2 ='checked';
          }
           
          
          $bandera1 = '<input type="checkbox" '.$ncheck1.' onclick="GuardaDocumento(1,'.$idproceso.','.$idtarea.','.$x['idproceso_docu'].',this)" '.$check1.'> ';
          $bandera2 = '<input type="checkbox" '.$ncheck2.' onclick="GuardaDocumento(2,'.$idproceso.','.$idtarea.','.$x['idproceso_docu'].',this)" '.$check2.'> ';
          
          echo ' <tr>
				<td>'.$cnombre.'</td>
				<td>'.$bandera1.'</td>
                <td>'.$bandera2.'</td>
				</tr>';
          
      }
      
      echo	'</table>';
      
      
 
      
  } 
  //----------------------------------------------
  function notificacion( $idproceso,$idtarea ){
      
       
      $flujo = $this->bd->query_array('flow.wk_procesoflujo',
          'notificacion,tipotiempo,tiempo',
          'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
                        idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea,true)
          );
      
      $datos['notificacion'] = $flujo['notificacion'];
      $datos['tipotiempo']   = $flujo['tipotiempo'];
      $datos['tiempo']       = $flujo['tiempo'];
      
      
      $this->set->div_label(12,'<h5> Notificaciones <h5>');
      
      $MATRIZ = array(
          '-'    => '-',
           'S'    => 'Si',
          'N'    => 'No'
      );
      
      $evento = ' ';
      $this->obj->list->listae('Notificar',$MATRIZ,'notificacion',$datos,'required','',$evento,'div-3-9');
  
      $MATRIZ = array(
          '-'    => '-',
          'hora'    => 'hora'
       );
      
     
      
      $evento = ' ';
      $this->obj->list->listae('Unidad Tiempo',$MATRIZ,'tipotiempo',$datos,'required','',$evento,'div-3-9');
      
      
      $this->obj->text->text('Duracion',"texto",'tiempo',70,70,$datos,'required','','div-3-9') ;
      
      echo '<p>&nbsp;</p>';
      
  } 
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
 
  
  if (isset($_GET['id']))	{
  	
  	
  	$id         = $_GET['id'];
  	
  	$idproceso  = $_GET['idproceso'];
  	
  	$gestion->tabDatos($idproceso,$id);
  	
 
  
  	
  }
 
 ?>
