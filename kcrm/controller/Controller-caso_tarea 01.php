<style>
/* Style the tab */
.tab {
  float: left;
  border: none;
  background-color: #f1f1f1;
  width: 15%;
  height: 650px;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: #1f5f96;
  padding: 14px 10px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 14px;
  font-weight: 500;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
 border: none;
  width: 85%;
  border-left: none;
  height: 650px;
}
</style>
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
 })
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
      function Formulario( $idproceso, $vestado){
          
          $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
          
          $datos = array();
          
          $this->BarraHerramientas($vestado);
          
          
          echo '<div class="tab">
              <button class="tablinks" onclick="openCity(event, '."'home'".')" id="defaultOpen">1. Solicita</button>
              <button class="tablinks" onclick="openCity(event, '."'f1'".')">2. Formulario de Datos</button>
              <button class="tablinks" onclick="openCity(event, '."'f2'".')">3. Documentos</button>
             <button class="tablinks" onclick="openCity(event, '."'f3'".')">4. Requisitos</button>
             <button class="tablinks" onclick="openCity(event, '."'f4'".')">5. Proximo Evento</button>
            </div>';



          echo '<div id="home" class="tabcontent">';
          
                  $this->set->div_panel(utf8_encode  ('<b> PASO 1.  INFORMACION SOLICITANTE </b>'));
                  
                  $this->tarea->Formulario_solicita( );
                  
                  $this->set->div_panel('fin');
                  
                  $this->set->div_panel(utf8_encode  ('<b> PASO 2.  INFORMACION INCIDENCIA</b>'));
                  
                  
                  $this->tarea->detalle_tarea( $idproceso,1);
                  
                  
                  $this->set->div_panel('fin');
          
         echo  '</div><div id="f1" class="tabcontent">';
               
                $this->set->div_panel(utf8_encode  ('<b> PASO 3.  FORMULARIO DE DATOS</b>'));
                
                $nro =     $this->tarea->Formulario6( $idproceso,1);
                
                $this->set->div_panel('fin');
            
         echo  '</div><div id="f2" class="tabcontent">';
             
                $this->tarea->documentos_tarea( $idproceso,1);
         
         echo  '</div><div id="f3" class="tabcontent">';
                
                $this->tarea->requisitos_tarea( $idproceso,1);
                
      
          echo  '</div><div id="f4" class="tabcontent">';
                
                  $this->set->div_panel(utf8_encode  ('<b> PASO 5.  SIGUIENTE TAREA</b>'));
                  
                  $this->tarea->siguiente_tarea( $idproceso,1);
                  
                  $this->set->div_panel('fin');
                
                
          echo  '</div>';
 
           
          
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
                  array( boton => 'Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
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
			
		posicion_x=(screen.width/2)-(ancho/2);
		posicion_y=(screen.height/2)-(largo/2); 

		  var imagen = '<img src="../../kimages/m_verde.png" align="absmiddle">';
		  
		  var opcion_seleccionada = $("#vidproceso option:selected").text();
		  
		  $("#result").html( '<b>'+imagen+' ' + opcion_seleccionada + '</b>' ); 
		  

	    $( document ).ready( function() {


	    		openCity(event,"home");
	    	
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

	  function openCity(evt, cityName) {
		  var i, tabcontent, tablinks;
		  
		  tabcontent = document.getElementsByClassName("tabcontent");
		  
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }
		  
		  tablinks = document.getElementsByClassName("tablinks");
		  
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  
		  document.getElementById(cityName).style.display = "block";
		  evt.currentTarget.className += " active";
		}
	  
//----------------------------------------------------------------------
	  function limpiar_mensaje( htmldato ){
		  
			 
		    var editorInstance = editor_msj.data('wysihtml5').editor;
		    
		    editorInstance.setValue(htmldato, true);


		}


	  // Get the element with id="defaultOpen" and click on it
	  
	  // document.getElementById("defaultOpen").click();	 
	  
</script>     