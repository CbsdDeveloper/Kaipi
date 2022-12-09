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
            				
                         	 jQuery('#result').html(data);
            
                         	 jQuery( "#result" ).fadeOut( 1600 );
            
                         	 jQuery("#result").fadeIn("slow");
                        
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
    
    require 'Controller-forma.php'; /*Incluimos el fichero de la clase objetos*/
    
  
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
                
                 $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
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


		  echo ' <ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#home"><span class="blue">1</span> <b>Solicita</b></a></li>
					<li><a data-toggle="tab" href="#f2"><span class="blue">2</span> <b>Documentos</b></a></li>
					<li><a data-toggle="tab" href="#f4"><span class="blue">3</span> <b>Siguiente</b></a></li>
 			</ul>';

          
 
           echo '   <div class="tab-content">';
 
           echo '<div id="home" class="tab-pane active" style="padding-top:20px">';
          
 
				   $this->set->div_panel6('<b> PASO 1.  INFORMACION SOLICITANTE </b>' );
                  
                  
						   $this->tarea->Formulario_solicita( );
   
   
  				   $this->set->div_panel6('fin');

                    
                  $this->set->div_panel6('<b> PASO 2.  DETALLE/DESCRIPCION</b>' );
                  
                  
                 		 $this->tarea->detalle_tarea( $idproceso,1);
                  
                  
                  $this->set->div_panel6('fin');



                  
                  $this->set->div_panel('<b> PASO 3.  FORMULARIO DE DATOS</b>');
                  
                 		 $nro =     $this->tarea->Formulario6( 0,$idproceso,1);
                  
                  $this->set->div_panel('fin');


                  
                  
          
         echo  '</div>';
                 
            
         echo  '<div id="f2" class="tab-pane" style="padding-top:20px">
		 			<div class="col-md-9">';
             
              			    $this->tarea->documentos_tarea( $idproceso,1);
				                
							$evento = "openFile('../../upload/uploadDoc_tramite',650,320)";
							echo '  <div class="col-md-12"> ';
							echo '<button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" >    Agregar Archivos/Documentos</button></div>	' ;
                 
							echo '  <div class="col-md-12"  style="padding-top: 5px"> ';
							echo '<div id="ViewFormfile"> </div>';
							echo '</div>';

							echo '  <div class="col-md-12"  style="padding-top: 5px"> ';
									$this->tarea->requisitos_tarea( $idproceso,1);
							echo '</div>' ;
                
 
                
      
          echo  '</div></div><div id="f4" class="tab-pane" style="padding-top:20px">';
                
                  $this->set->div_panel(utf8_encode  ('<b> PASO 5.  SIGUIENTE TAREA</b>'));
                  
                  $this->tarea->siguiente_tarea( $idproceso,1);
                  
                  $this->set->div_panel('fin');
                
                
          echo  '</div></div></div>';
 
           
   
          $this->obj->text->texto_oculto("proceso_codigo",$datos);
          $this->obj->text->texto_oculto("action",$datos);
          $this->obj->text->texto_oculto("estado",$datos);
          $this->obj->text->texto_oculto("autorizado",$datos);
          
                
          $datos['nro_objetos'] = $nro ;
          $this->obj->text->texto_oculto("nro_objetos",$datos);
          $this->set->_formulario('-','fin'); 
          
          
        
      }
      
      //----------------------------------------------
      function BarraHerramientas($vestado){
          
           
          $evento 				= 'EnviarProceso();';
          $evento1 				= 'FinProceso();';
          $formulario_impresion = '../view/cliente';
          $eventoc 				= 'openView('."'".$formulario_impresion."')";
          
        
              $ToolArray = array(
                  array( boton => 'Nuevo ',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                  array( boton => 'Guardar ', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                  array( boton => 'Enviar ',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                  array( boton => 'Finalizar ',  evento =>$evento1,  grafico => 'glyphicon glyphicon-record' ,  type=>"button_danger"),
                  array( boton => 'Nuevo Solicita', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
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
   $vestado           		= $_GET['estado'];
    
   
   $gestion->Formulario( $id,$vestado );

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
		  
		
		$("#caso").html( htmldato );  
			 
	 


		}
 
	  
</script>     