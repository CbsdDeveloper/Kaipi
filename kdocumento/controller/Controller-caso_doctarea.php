<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
<script >// <![CDATA[

   jQuery.noConflict(); 


	var handleTabs = function() {
		// function to fix left/right tab contents
		var fixTabHeight = function(tab) {
			$(tab).each(function() {
				var content = $($($(this).attr("href")));
				var tab = $(this).parent().parent();
				if (tab.height() > content.height()) {
					content.css('min-height', tab.height());
				}
			});
		}

		// fix tab content on tab click
		$('body').on('click', '.nav.nav-tabs.tabs-left a[data-toggle="tab"], .nav.nav-tabs.tabs-right a[data-toggle="tab"]', function(){
			fixTabHeight($(this));
		});

		// fix tab contents for left/right tabs
		fixTabHeight('.nav.nav-tabs.tabs-left > li.active > a[data-toggle="tab"], .nav.nav-tabs.tabs-right > li.active > a[data-toggle="tab"]');

		// activate tab if tab id provided in the URL
		if (location.hash) {
			var tabid = location.hash.substr(1);
			$('a[href="#'+tabid+'"]').click();
		}
	}
	
   
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
      function Formulario( $idproceso){
          
          $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
          
          $datos = array();
          
          $this->BarraHerramientas('');
          
          
          echo '<div class="tabbable tabbable-custom tabs-left">
                <ul class="nav nav-tabs tabs-left">
                      <li class="active"><a href="#home" data-toggle="tab"><span class="blue">1</span> <b>Solicita</b></a></li>
                      <li><a href="#f2" data-toggle="tab"><span class="blue">2</span> <b>Archivos</a></b></li>
                 </ul>  
                <div class="tab-content">';
 
           echo '<div id="home" class="tab-pane active">';
          
                  $this->set->div_panel(utf8_encode  ('<b> PASO 1.  INFORMACION SOLICITANTE </b>'));
                  
                  $this->tarea->Formulario_solicita( );
                  
                  $this->set->div_panel('fin');
                  
                  $this->set->div_panel(utf8_encode  ('<b> PASO 2.  INFORMACION INCIDENCIA</b>'));
                  
                  
                  $this->tarea->detalle_tarea( $idproceso,1);
                  
                  
                  $this->set->div_panel('fin');
                  
                  $this->set->div_panel(utf8_encode  ('<b> PASO 3.  GENERAR DOCUMENTO ELECTRONICO</b>'));
                  
                 
                  echo '<button type="button" onclick="formato_doc();" class="btn btn-default" id="CargaEditor_133">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button>
                                <button type="button" onclick="formato_doc_visor();" class="btn btn-default" id="CargaEditorP_133">
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                </button> ';
                  
                  $this->set->div_panel('fin');
                  
                  
          
         echo  '</div>';
                 
            
         echo  '<div id="f2" class="tab-pane"><div class="col-md-9">';
             
                 
                
                $evento = "openFile('../../upload/uploadDoc_tramite',650,320)";
                echo '  <div class="col-md-12"> ';
                echo '<button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" >
										  Cargar Documentos</button>	' ;
                echo '</div>';
                
                echo '  <div class="col-md-12"  style="padding-top: 5px"> ';
                echo '<div id="ViewFormfile"> </div>';
                echo '</div>';
                
         
         echo  '</div></div>';
                
               
                
         
      
          echo  '</div></div>';
 
           
          
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
          
         // $id =  $_SESSION['idcaso'];
          
          $evento = 'javascript:EnviarProceso();';
          $evento1 = 'javascript:FinProceso();';
          
          $formulario_impresion = '../view/cliente';
          $eventoc = 'javascript:openView('."'".$formulario_impresion."')";
          
        
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
     
   
   $gestion->Formulario( $id );

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


	   editor_msj  = new jQuery('#caso').wysihtml5();
	  	
 
  
	  
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
		  
			 
		    var editorInstance = editor_msj.data('wysihtml5').editor;
		    
		    editorInstance.setValue(htmldato, true);


		}
 
	  
</script>     