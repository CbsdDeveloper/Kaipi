<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
<script >// <![CDATA[
  jQuery.noConflict(); 
	jQuery(document).ready(function() {
  		
               // InjQueryerceptamos el evento submit
                jQuery('#form, #fat, #fo3').submit(function() {
              		// Enviamos el formulario usando AJAX
                    jQuery.ajax({
                        type: 'POST',
                        url: jQuery(this).attr('action'),
                        data: jQuery(this).serialize(),
                        // Mostramos un mensaje con la respuesta de PHP
                        success: function(data) {
            				
							jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
            
                         	 jQuery( "#result" ).fadeOut( 1600 );
            
                         	 jQuery("#result").fadeIn("slow");

							  let text      = data;
							  const myArray = text.split("-");
							  var idcaso    = myArray[1]; 		
							  var id        = parseInt(idcaso) 

							  
							  if (id > 0 )  {
								  visor_editor( id );
								} 

            			} 
						 
                    })        
                    return false;
                }); 
});
</script>	
<?php 
session_start( );   
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
require 'Controller-forma.php'; 

class componente{
 
  
      private $obj;
      private $bd;
      private $tarea;
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
                $this->bd	   =	new  Db ;
                
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
				$this->hoy 	     =  date("Y-m-d");

                $this->usuario 	 =  trim($_SESSION['usuario']);
        		$this->tarea     = 	new tareaProceso(  $this->obj, $this->set, $this->bd);
                
                $this->formulario = 'Model-cli_incidencias.php';
                $this->evento_form = '../model/'. $this->formulario;        
      }
  ///------------------------------------------------------------------------
      function Formulario( $idproceso, $vestado){
          
          $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
          
          $datos = array();
          
          $this->BarraHerramientas($vestado);
           
          echo '<ul class="nav nav-pills" id="mytabsDato">
                      <li class="active"><a href="#home" data-toggle="tab"><span class="blue">1</span> &nbsp;<b>DE / PARA</b></a></li>
                      <li><a href="#f2" data-toggle="tab"><span class="blue">2</span> &nbsp;<b>Documento</a></b></li>
					  <li><a href="#f3" data-toggle="tab"><span class="blue">3</span> &nbsp;<b>Archivos Adjuntos</a></b></li>
                     
                </ul>  
                <div class="tab-content">';

 						echo '<div id="home" class="tab-pane active">';
					
										$this->set->div_label(12,'<b> PASO 1.  INFORMACION SOLICITANTE </b>');
										
														$this->tarea->Formulario_solicita( );
										
										$this->set->div_panel5('<b> PASO 2.  INFORMACION  EXTRACTO DEL DOCUMENTO</b>') ;
										
														$this->tarea->detalle_tarea( $idproceso,1);
										
										$this->set->div_panel5('fin');
						
										$this->set->div_panel7( '<b> PASO 3.  ENVIAR PARA</b> Para agregar funcionario presione en el icono de PARA y/o CC');
										
														$this->tarea->siguiente_tarea_doc_inicio( $idproceso,1);
										
										$this->set->div_panel7('fin');
										
										$this->set->div_panel( '<b> PASO 4. RESPONSABLES ASIGNADOS PARA/CCOPIA</b>') ;
										
														echo '<div id="ViewFormfilepara"> </div>';
										
													

										$this->set->div_panel('fin');

										echo ' <div class="col-md-12" style="padding-top: 5px;padding-bottom: 5px"  align="center">';

										$evento = 'javascript:SiguienteDato(1)';

										echo ' <button type="submit" onclick="'.$evento.'"  class="btn btn-primary btn-lg">SIGUIENTE PASO... </button>';

										 echo ' </div>';
                  
         				 echo  '</div>';
					

						  
						$datos['action'] 		 = 'add';
						$datos['estado']  		 = '1';
						$datos['proceso_codigo']  = '21';
			
						$this->obj->text->texto_oculto("proceso_codigo",$datos);
						$this->obj->text->texto_oculto("action",$datos);
						$this->obj->text->texto_oculto("estado",$datos);
						$this->obj->text->texto_oculto("autorizado",$datos);


		 $this->set->_formulario('-','fin'); 
		   
 
         echo  '<div id="f2" class="tab-pane">
		 			<div class="col-md-12">';

					 echo  '<iframe src="cli_editor_caso_add.php" width="100%" height="1050px" frameborder="0" id="ieditor" name="ieditor">
									</iframe>';
						
		 echo  '</div></div>';

		 echo '<div id="f3" class="tab-pane">
		 			<div class="col-md-12"> ';

										$evento = "Ver_doc_user_lista()";
 
										echo '  <div class="col-md-6"  style="padding: 15px">
												<button type="button" class="btn btn-sm btn-success" onclick="'.$evento.'" > Visualizar Documentos</button> 
												<h4>Documentos Elaborados</h4> ';
												echo '<div id="ViewFormfileDoc"> </div> 
												<h6 align="center">No se olvide de cerrar (bloquear) el documento generado!!!</h6> ';
										echo '</div>';
										

										$evento = "openFile('../../upload/uploadDoc_tramite',650,360)";
										echo '  <div class="col-md-6"  style="padding: 15px">
												<button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" > Cargar/Adjuntar Documento</button>
												<h4>Archivos Disponibles</h4> ';
												echo '<div id="ViewFormfile"> </div>';
										echo '</div>';

				 echo '</div>
						 	</div>';	
 
          echo  ' 
		  	   </div>
		  	 </div>';
            

	   
			 
          
        
      }
	  //----------------------------------------------
	  function Formulario02( $idproceso, $vestado){
        	
		$datos = array();
		
		$this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion

		$this->BarraHerramientas_seg($vestado);
		 
		echo '<ul class="nav nav-pills">
					<li class="active"><a href="#home" data-toggle="tab"><span class="blue">1</span> &nbsp;<b>Para/Solicita </b></a></li>
					<li><a href="#f2" data-toggle="tab"><span class="blue">2</span> &nbsp;<b>Archivos Adjuntos/Documento</a></b></li>
 			  </ul>  
			  <div class="tab-content">';

					   echo '<div id="home" class="tab-pane active">';
				  
									  $this->set->div_label(12,'<b> PASO 1.  INFORMACION SOLICITANTE </b>');
									  
													  $this->tarea->Formulario_solicita( );
									  
									  $this->set->div_panel6('<b> PASO 2.  INFORMACION  ASUNTO DEL DOCUMENTO</b>') ;
									  
													  $this->tarea->detalle_tarea( $idproceso,1);
									  
									  $this->set->div_panel6('fin');
 									   
									  
									  $this->set->div_panel6( '<b> Responsables asignados</b>') ;
									  
													  echo '<div id="ViewFormfilepara"> </div>';
									  
									  $this->set->div_panel6('fin');
				
						echo  '</div>';
				  
 			
					  $datos['action'] 		 = 'edit';
					  $datos['estado']  		 = '2';
					  $datos['proceso_codigo']  = '21';
		  
					  $this->obj->text->texto_oculto("proceso_codigo",$datos);
					  $this->obj->text->texto_oculto("action",$datos);
					  $this->obj->text->texto_oculto("estado",$datos);
					  $this->obj->text->texto_oculto("autorizado",$datos);

 
	   echo  '<div id="f2" class="tab-pane">
				   <div class="col-md-12">';
 

				   $evento = "Ver_doc_user_lista()";

				   echo '  <div class="col-md-6"  style="padding: 15px">
						   <button type="button" class="btn btn-sm btn-success" onclick="'.$evento.'" > Visualizar Documentos</button> 
						   <h4>Documentos Elaborados</h4> ';
						   echo '<div id="ViewFormfileDoc"> </div> 
						   <h6 align="center">No se olvide de cerrar (bloquear) el documento generado!!!</h6> ';
				   echo '</div>';
				   

				   $evento = "openFile('../../upload/uploadDoc_tramite',650,360)";
				   echo '  <div class="col-md-6"  style="padding: 15px">
						   <button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" > Cargar/Adjuntar Documento</button>
						   <h4>Archivos Disponibles</h4> ';
						   echo '<div id="ViewFormfile"> </div>';
				   echo '</div>';
 	 

		echo  '   </div> </div>
			 </div>';
		  

	  $this->set->_formulario('-','fin'); 
		 
		
	  
	}
      
      //----------------------------------------------
      function BarraHerramientas($vestado){
          
         // $id =  $_SESSION['idcaso'];
          
          $evento  = 'EnviarProceso();';
          $evento1 = 'FinProceso();';
		  $evento2 = 'ReasignarProceso();';
          
          $formulario_impresion = '../view/cliente';
          $eventoc = 'openView('."'".$formulario_impresion."')";


	
          
        
              $ToolArray = array(
                   array( boton => 'Guardar ', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
				   array( boton => 'Re-Asignar ',  evento =>$evento2,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_info"),
                   array( boton => 'Enviar ',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                   array( boton => 'Nuevo Solicita', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
              );
              
       
          
          $this->obj->boton->ToolMenuDivCrm($ToolArray);
          
      }
//------------------------------
	  function BarraHerramientas_seg($vestado){
          
 		 
		 $evento = 'EnviarProceso();';
		 $evento1 = 'FinProceso();';
		 
		 $formulario_impresion = '../view/cliente';
		 $eventoc = 'openView('."'".$formulario_impresion."')";
		 
	   
			 $ToolArray = array(
 				 array( boton => 'FINALIZAR PROCESO ',  evento =>$evento1,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
 			 );
			 
	  
		 
		 $this->obj->boton->ToolMenuDivCrm($ToolArray);
		 
	 }

      //----------------------------------------------
      function header_titulo($titulo){
          
          $this->set->header_titulo($titulo);
          
      }  
 }   
 //-------------------------------------------
  
 
   $gestion   = 	new componente;
  
   $id            	    	= $_GET['idproceso'];
   $vestado           		= trim($_GET['estado']);
    
   if (    $vestado    == '1'){
  		 $gestion->Formulario( $id,$vestado );
   }  


   if (    $vestado    == '2'){
	$gestion->Formulario02( $id,$vestado );
	}  

?>
<script>
 
		var posicion_x; 
		var posicion_y; 

		var ancho = 450;
		var largo = 220;
			
		posicion_x=( screen.width/2 ) - (ancho/2);
		posicion_y=( screen.height/2 ) - (largo/2); 

		  var imagen = '<img src="../../kimages/m_verde.png" align="absmiddle">';
		  
		  var opcion_seleccionada = $("#vidproceso option:selected").text();
		  
		  $("#result").html( '<b>'+imagen+' ' + opcion_seleccionada + '</b>' ); 
		  

	    $( document ).ready( function() {


 	    	
				$("a[rel='pop-up']").click(function () {
					var caracteristicas = "height=220,width=450,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			   });
    
    	       ancho = 550;
    		   largo = 350;			
		 	 
			   posicion_x=(screen.width/2)-(ancho/2);
			   posicion_y=(screen.height/2)-(largo/2); 
			
			 $("a[rel='pop-upo']").click(function () {
					var caracteristicas = "height=350,width=550,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
					nueva=window.open(this.href, 'Popup', caracteristicas);
					return false;
			 });


  	         ancho = 1120;
		     largo = 350;			
	 	 
		     posicion_x=(screen.width/2)-(ancho/2);
		     posicion_y=(screen.height/2)-(largo/2); 
		
		     $("a[rel='pop-up_form']").click(function () {
				var caracteristicas = "height=350,width=1120,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
				nueva=window.open(this.href, 'Popup', caracteristicas);
				return false;
		     });

		     
			 
		});

	    var editor_msj;
	    
  	    jQuery.noConflict(); 


 	  	
 
  
	  
	  jQuery('#razon').typeahead({
	 	    source:  function (query, process) {
	         return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
	         		console.log(data);
	         		data = $.parseJSON(data);
	 	            return process(data);
	 	        });
	 	    } 
	 	});


	  jQuery('#idprov').typeahead({
	 	    source:  function (query, process) {
	      return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
	      		console.log(data);
	      		data = $.parseJSON(data);
	 	            return process(data);
	 	        });
	 	    } 
	 	});
	  

	  
	  $("#razon").focusout(function(){
	 	 
	 	 		    var itemVariable = $("#razon").val();  
	 	 
	         		var parametros = {
	 											"itemVariable" : itemVariable 
	 									};
	 									 
	 									$.ajax({
	 										    type:  'GET' ,
	 											data:  parametros,
	 											url:   '../model/AutoCompleteIDMultiple.php',
	 											dataType: "json",
	  											success:  function (response) {

 	 													 $("#idprov").val( response.a );  
	 													 $("#telefono").val( response.b );  
	 													 $("#correo").val( response.c );  
	 												 
	 													  
	 											} 
	 									});
	 	 
	     });


	  $("#idprov").focusout(function(){
	 	 
	 	    var itemVariable = $("#idprov").val();  

	 		var parametros = {
	 									"itemVariable" : itemVariable 
	 							};
	 							 
	 							$.ajax({
	 								    type:  'GET' ,
	 									data:  parametros,
	 									url:   '../model/AutoCompleteIDMultipleID.php',
	 									dataType: "json",
	 									success:  function (response) {

	 										
	 											 $("#razon").val( response.a );  
 	 											 $("#telefono").val( response.b );  
												 $("#correo").val( response.c );  
	 											  
	 									} 
	 							});

	 });

		// valida botones ----------
		
	  function valida_botones()
	  {

	  	 	 
	  			
	  		  var estado = $("#vestado").val(); 

	    
	  		    if (estado == '0' ){
	   				 $("#button_nuevo").prop('disabled',false);
	  				 $("#guardaicon").prop('disabled',false);
	  				 $("#button2").prop('disabled',false);
	  				 $("#button3").prop('disabled',true);
	  				 $("#sesion_siguiente").prop('disabled',false);
	   		    }

	  			 if (estado == '1' ){

 

	   				 $("#button_nuevo").prop('disabled',false);
	  				 $("#guardaicon").prop('disabled',false);
	  				 $("#button2").prop('disabled',false);
	   				 $("#button3").prop('disabled',true);
	   
	   				 $("#sesion_siguiente").prop('disabled',false);

	   		    }

	  			  if (estado == '2' ){
	   				 $("#button_nuevo").prop('disabled',true);
	  				 $("#guardaicon").prop('disabled',true);
	  				 $("#button2").prop('disabled',true);
	  				 $("#button3").prop('disabled',true);
	   		    }

	  			  if (estado == '3' ){
	   	 	    	 $("#button_nuevo").prop('disabled',true);
	  				 $("#guardaicon").prop('disabled',true);
	  				 $("#button2").prop('disabled',true);
	  				 $("#button3").prop('disabled',true);
	   		    }


	  			if (estado == '4' ){
	   				 $("#button_nuevo").prop('disabled',true);
	  				 $("#guardaicon").prop('disabled',true);
	  				 $("#button2").prop('disabled',true);
	  				 $("#button3").prop('disabled',false);

	  				 $("#sesion_siguiente").prop('disabled',true);

	  				 $("#mensaje_siguiente").html( '');  
 	  				
	  				
	  			 }

	  			if (estado == '5' ){
	   				 $("#button_nuevo").prop('disabled',true);
	  				 $("#guardaicon").prop('disabled',true);
	  				 $("#button2").prop('disabled',true);
	  				 $("#button3").prop('disabled',true);

	  				 $("#sesion_siguiente").prop('disabled',true);

	  				 $("#mensaje_siguiente").html( '');  
	  				
 	  			 }
 
   }		 

	 
	  
//----------------------------------------------------------------------
	  function limpiar_mensaje( htmldato ){
		  
	       
 
			 $("#caso").html( htmldato);  

			

		}
 /*
 */


	  
</script>     