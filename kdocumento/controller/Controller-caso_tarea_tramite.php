<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
<script >// <![CDATA[
   jQuery.noConflict(); 
 	 
 	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
             	 jQuery('#result').html(data);
 
 				  jQuery( "#result" ).fadeOut( 1000 );

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
                
                $this->formulario = 'Model-cli_incidencias_tarea.php';
                
                $this->evento_form = '../model/'. $this->formulario;        
                
      }
  ///------------------------------------------------------------------------
  
      function Formulario( $idproceso, $tarea,$idcaso,$doc_user){
 

           $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
          
           $datos = array();
          
           $this->BarraHerramientas($idcaso);
           
           $datos_doc = $this->bd->query_array('flow.wk_proceso_casodoc',
                                                'documento, asunto, tipodoc, para, de, editor,idcasodoc',
                                                'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true) ." and 
                                                 bandera = 'N' and uso = 'S' and 
                                                 sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion,true) 
                );

            if (  $datos_doc['idcasodoc'] > 0 ){
                    $cadena = '&accion=edit&iddoc='.$datos_doc['idcasodoc'];
            }else{
                 $cadena = '&accion=add&iddoc=0';
            }


            $qquery = array(
                array( campo => 'idcaso',   valor => $idcaso,  filtro => 'S',   visor => 'S'),
                array( campo => 'caso',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'sesion_siguiente',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
                array( campo => 'autorizado',   valor => '-',  filtro => 'N',   visor => 'S') ,
                array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S')
            );
            
           $datos_1 = $this->bd->JqueryArrayVisorDato('flow.wk_proceso_caso',$qquery );   
           
           $datos['codigoproceso'] = $idproceso ;
           $datos['tarea_actual']  = $tarea ;
           $datos['action']        = 'edit' ;
           $datos['doc_user']      = $doc_user;
           
           $datos['estado']            =   $datos_1['estado'] ;
           $datos['autorizado']        =   $datos_1['autorizado']  ;


           echo '<ul class="nav nav-pills" id="tab_dato">
                      <li class="active"><a href="#home" data-toggle="tab"><span class="blue">1</span> <b>DE / SOLICITA</b></a></li>
                      <li><a href="#f4" data-toggle="tab"><span class="blue">2</span> <b> Responder a </a></b></li>
                      <li><a href="#f3" data-toggle="tab"><span class="blue">3</span> <b> Elaborar Documento </a></b></li>
                   
                     
                   </ul>
                <div class="tab-content"  style="padding-top: 15px;padding-bottom: 15px" >';
  
          
           echo '<div id="home" class="tab-pane active">';
          
                                $this->set->div_panel('<b> PASO 1.  INFORMACION SOLICITA </b>') ;
                                
                                            $this->tarea->Formulario_solicita_tramite( $idcaso );
                                          
                                            
                                            $evento = "openFile('../../upload/uploadDoc_tramite',650,360)";

                                            $evento1 = "Ver_doc_user_lista()";
                           
                                                       echo '<div class="col-md-12"> 
                                                                   <div class="col-md-6"  style="padding: 15px">
                                                                  
                                                                    <h4>Documentos Elaborados</h4> 
                                                                                                <div id="ViewFormfileDoc"> </div>
                                                                    </div>
                                                                   <div class="col-md-6"  style="padding: 15px">
                                                                          
                                                                           <h4>Archivos Adjuntos  Disponibles</h4>
                                                                           <div id="ViewFormfile"> </div> <br>
                                                                           <button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" > Adjuntar/Cargar Documentos</button> 
                                                                   </div>
                                                                   <div id="VisorTarea">  </div> 
                                                                   <div id="Resultados">  </div>
                                                       </div>';
                                           
                                $this->set->div_panel('fin');
                        
                                $this->set->div_panel('<b> PASO 2.  INFORMACION INCIDENCIA</b>');
                            
                                            $this->tarea->detalle_tarea_casos( $idcaso,$idproceso,$tarea);
                         
                                $this->set->div_panel('fin');
          
          echo  '</div>';
           
          echo  '<div id="f4" class="tab-pane">';
          
                 $this->set->div_panel( '<b> PASO 3.  SIGUIENTE TAREA</b>');
                     
                              $this->tarea->siguiente_tarea_doc( $idproceso,$tarea,$idcaso);

 
                             
                 $this->set->div_panel('fin');
          
        echo  '</div>';        
               
             
        echo  '<div id="f3" class="tab-pane">';
          
                echo  '<iframe src="cli_editor_caso_seg.php?id='.$idcaso.  $cadena.'" width="100%" height="1050px" frameborder="0" id="ieditor" name="ieditor">  </iframe>';
 
        echo  '</div>';       

        echo  '<div id="f2" class="tab-pane">';
          
               
  
               
          $this->obj->text->texto_oculto("codigoproceso",$datos);
           $this->obj->text->texto_oculto("action",$datos);
          $this->obj->text->texto_oculto("estado",$datos);
          $this->obj->text->texto_oculto("autorizado",$datos);
          $this->obj->text->texto_oculto("doc_user",$datos);
          
          
  
          $this->set->_formulario('-','fin'); 
          
      }
      
      //----------------------------------------------
      function BarraHerramientas($idcaso){
          
          
 
          
          $Atarea = $this->bd->query_array('flow.view_proceso_caso',
                                           'estado, sesion, responsable, idtareactual, autorizado,
                                            responsable_proceso, siguiente, idprov,   sesion_actual,
                                            email_actual,  sesion_siguiente, email_siguiente, email_solicita,  dias_trascurrido,
                                            fvencimiento, dias_tramite', 
                                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true));
          
          
          $bandera = 0;

 
          
          if ( $Atarea['estado'] == '4' ){
              $bandera = 1;
          }elseif($Atarea['estado'] == '5' ){
              $bandera = 3;
          }elseif($Atarea['estado'] == '2' ){
            $bandera = 2;
          }elseif($Atarea['estado'] == '3' ){
            $bandera = 2;
          }
          
       
          //----------------- sesion actual 
          if ( $bandera == 2 ) {
              
              $evento  = 'EnviarProcesoSeg();';
              $evento1 = 'AnularProceso();';
              $evento2 = 'TerminarProceso();';
              $evento3 = 'LeerProceso();';

              $ToolArray = array(
                  array( boton => 'Guardar Doc', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                  array( boton => 'Marcar leido ',    evento =>$evento3,  grafico => 'glyphicon glyphicon-thumbs-up' ,  type=>"button_success"),
                  array( boton => 'Enviar Doc ',    evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                  array( boton => 'Anular ',    evento =>$evento1,  grafico => 'glyphicon glyphicon-ban-circle' ,  type=>"button_danger"),
                  array( boton => 'Terminar ',  evento =>$evento2,  grafico => 'glyphicon glyphicon-exclamation-sign' ,  type=>"button_info")
              );
              
              $this->obj->boton->ToolMenuDivCrm($ToolArray);
          }
         
            
          //----------------- sesion due�a del proceso
          if ( $bandera == 3 ) {
              
              $evento = 'ReporteProceso();';
              
              $ToolArray = array(
                  array( boton => 'Reporte ',  evento =>$evento,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button")
              );
              
              $this->obj->boton->ToolMenuDivCrm($ToolArray);
          }
          
          
         
          
      }
      //----------------------------------------------
      function header_titulo($titulo){
          
          $this->set->header_titulo($titulo);
          
      }  
  
  
      
 }   
 
 
   $gestion   = 	new componente;
  
   $id            		= $_GET['idproceso'];
   
   $tarea            	= $_GET['tarea'];
   
   $idcaso	            = $_GET['idcaso'];
   
   $doc_user            = $_GET['doc_user'];
   
   $gestion->Formulario( $id ,$tarea,$idcaso,$doc_user);
   
  // $gestion->pone_variables( $idcaso  );
   
 
?>
<script>
 
		var posicion_x; 
		var posicion_y; 

		var ancho = 450;
		var largo = 220;
			
		posicion_x=(screen.width/2)-(ancho/2);
		posicion_y=(screen.height/2)-(largo/2); 

 
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
		     largo = 400;			
	 	 
		     posicion_x=(screen.width/2)-(ancho/2);
		     posicion_y=(screen.height/2)-(largo/2); 
		
		     $("a[rel='pop-up_form']").click(function () {
				var caracteristicas = "height=400,width=1120,scrollTo,resizable=1,scrollbars=1,location=0" + ",left="+posicion_x+",top="+posicion_y;
				nueva=window.open(this.href, 'Popup', caracteristicas);
				return false;
		     });

		     
			 
		});


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
	 											 
	 										 
	 											  
	 									} 
	 							});

	 });
 
   $('#novedad').val('En proceso de revision...');
	  
</script>     