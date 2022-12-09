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
  
      function Formulario( $idproceso, $tarea,$idcaso){
          
          $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
          
           $datos = array();
          
           $this->BarraHerramientas($idcaso);
            
           echo ' <ul class="nav nav-pills">
           <li class="active"><a data-toggle="tab" href="#home"><span class="blue">1</span> <b>Solicitante</b></a></li>
           <li><a data-toggle="tab" href="#f4"><span class="blue">2</span> <b>Siguiente</b></a></li>
           <li><a data-toggle="tab" href="#f2"><span class="blue">3</span> <b>Documentos</b></a></li>
           <li><a data-toggle="tab" href="#f3"><span class="blue">4</span> <b>Requisitos</b></a></li>
       </ul>';

      
                echo '<div class="tab-content">';
           
 
          
           echo '<div id="home" class="tab-pane active"  style="padding-top:20px">';
          
          $this->set->div_panel('<b> PASO 1.  INFORMACION SOLICITANTE </b>');
          
                            $this->tarea->Formulario_solicita_tramite( $idcaso );
                            
                            $nro =     $this->tarea->Formulario6( $idcaso,$idproceso,$tarea);
          
          $this->set->div_panel('fin');
          
          $this->set->div_panel( '<b> PASO 2.  INFORMACION INCIDENCIA</b>') ;
            
                            $this->tarea->detalle_tarea_casos( $idcaso,$idproceso,$tarea);
           
          $this->set->div_panel('fin');
          
          echo  '</div>';
          
          
          
          echo  '<div id="f2" class="tab-pane"  style="padding-top:20px"><div class="col-md-9">';
          
                   $this->tarea->documentos_tarea( $idproceso,$tarea);

                   $evento = "openFile('../../upload/uploadDoc_tramite',650,320)";
                   
                   echo '  <div class="col-md-12" style="padding-top: 5px;padding-bottom:10px" > ';
                   echo     '<button type="button" class="btn btn-sm btn-danger" onclick="'.$evento.'" > Agregar Archivos/Documentos</button>
                           </div>	' ;

                           echo '  <div class="col-md-12"  style="padding-top: 5px"> ';
                           echo '<div id="ViewFormfile"> </div>';
                           echo '</div>';
 
          
         echo  '</div></div><div id="f3" class="tab-pane"  style="padding-top:20px"><div class="col-md-10"> ';
          
                   $this->tarea->requisitos_tarea( $idproceso,$tarea);
          
                  
          
       echo  '</div></div><div id="f4" class="tab-pane"  style="padding-top:20px">';
          
          $this->set->div_panel( '<b> PASO 3.  SIGUIENTE TAREA</b>' );
          
           $this->tarea->siguiente_tarea_caso( $idproceso,$tarea,$idcaso);
          
          $this->set->div_panel('fin');
          
          
          echo  '</div></div></div>';
          
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
         
         $datos['estado']            =   $datos_1['estado'] ;
         $datos['autorizado']        =   $datos_1['autorizado']  ;
              
          $this->obj->text->texto_oculto("codigoproceso",$datos);
          $this->obj->text->texto_oculto("tarea_actual",$datos);
          $this->obj->text->texto_oculto("action",$datos);
          $this->obj->text->texto_oculto("estado",$datos);
          $this->obj->text->texto_oculto("autorizado",$datos);
          
               
          $datos['nro_objetos'] = $nro ;
          
          $this->obj->text->texto_oculto("nro_objetos",$datos);
          
          $this->set->_formulario('-','fin'); 
          
      }
      
      //----------------------------------------------
      function BarraHerramientas($idcaso){
          
          
        $xdatos       = $this->bd->query_array('par_usuario','completo,cedula,email,movil,responsable', 'email='.$this->bd->sqlvalue_inyeccion(  $this->sesion ,true));
 
          
          $Atarea = $this->bd->query_array('flow.view_proceso_caso',
                                           'estado, sesion, responsable, idtareactual, autorizado,
                                            responsable_proceso, siguiente, idprov,   sesion_actual,
                                            email_actual,  sesion_siguiente, email_siguiente, email_solicita,  dias_trascurrido,
                                            fvencimiento, dias_tramite', 
                                            'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true));
          
          
          $bandera = 0;
          
 
          
          
          if (trim($this->sesion) == trim($Atarea['sesion']) ) {
              
              if ( $Atarea['siguiente'] == 99 ){
                  $bandera = 1;

              }else{

                  if (trim($this->sesion) == trim($Atarea['email_actual']) ) {
                      $bandera = 2;
                  }else {
                      $bandera = 3;
                  }
                      
              }
              
          }else  {
              
                 if (trim($this->sesion) == trim($Atarea['email_actual']) ) {
                       $bandera = 2;
                  }
                  $bandera = 2;
              
          }
          
          if ( $Atarea['estado']== '4' ){
              $bandera = 5;
          }
                 
             
          if ( $Atarea['estado']== '5' ){
            $bandera = 5;
        }

          if ( $xdatos['responsable']== 'S' ){
            $bandera = 15;
        }
          
 
          
          //----------------- sesion actual 
          if ( $bandera == 2 ) {
              
              $evento = 'EnviarProceso();';
              
              $ToolArray = array(
                  array( boton => 'Guardar Informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                  array( boton => 'Enviar proceso',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button")
              );
              
              $this->obj->boton->ToolMenuDivCrm($ToolArray);
          }

           //----------------- sesion actual 
           if ( $bandera == 15 ) {
              
            $evento  = 'EnviarProceso();';
            $evento11 = 'FinProceso();';

            $ToolArray = array(
                array( boton => 'Guardar Informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                array( boton => 'Enviar proceso',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                array( boton => 'Finalizar ',  evento =>$evento11,  grafico => 'glyphicon glyphicon-record' ,  type=>"button_danger")
            );
            
            $this->obj->boton->ToolMenuDivCrm($ToolArray);
        }
         

        


          //----------------- sesion due�a del proceso
          if ( $bandera == 3 ) {
              
              $evento   = 'AnularProceso();';
              $evento1  = 'EnviarProceso();';
              $ToolArray = array(
                array( boton => 'Guardar Informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit"),
                array( boton => 'Enviar proceso',  evento =>$evento1,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
                  array( boton => 'Anular proceso',  evento =>$evento,  grafico => 'glyphicon glyphicon-ban-circle' ,  type=>"button_danger")
              );
              
              $this->obj->boton->ToolMenuDivCrm($ToolArray);
          }
          
          
          //----------------- sesion due�a del proceso
          if ( $bandera == 5 ) {
              
              $evento = 'ReporteProceso();';
              
              $ToolArray = array(
                  array( boton => 'Reporte ',  evento =>$evento,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button")
              );
              
              $this->obj->boton->ToolMenuDivCrm($ToolArray);
          }
          
          
          //----------------- sesion due�a del proceso
          if ( $bandera == 0 ) {
              
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
  
      //-------------------------
      function pone_variables( $idcaso  ){
          
          
          
          $sql = 'SELECT  variable, valor,   orden
                  FROM flow.wk_proceso_caso_var
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and
                        valor is not NULL order by orden'    ;
          
          
  

          $resultado  = $this->bd->ejecutar($sql);
          
          while ($x=$this->bd->obtener_fila($resultado)){
              
              $cobjetos = 'col_'.trim( $x['orden'] );
              
              $valor = trim($x['valor'] );
              
              if ( $valor == '0'){
                  $valor = '0.00';
              }
              
              if ( !empty($valor)) {
                  
                  echo '<script> $("#'.$cobjetos.'").val("'.$valor.'" ); </script> ';
              }
              
              
          }
      }	
//----------------------------------
      function pone_requisitos( $idcaso  ){
          
          
          $Afolder = $this->bd->query_array('wk_config','carpeta', 'tipo='.$this->bd->sqlvalue_inyeccion(61,true));
          $folder = $Afolder['carpeta'];
          
          
          
          $sql = 'SELECT  idcasoreq, idproceso, sesion, idproceso_requi, idcaso, cumple, archivo
                  FROM flow.wk_proceso_casoreq
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and
                        cumple is not NULL'    ;
          
          
          $resultado  = $this->bd->ejecutar($sql);
          
          echo '<script>';
          
          while ($x=$this->bd->obtener_fila($resultado)){
              
              $cobjetos1 = 'cumple_'.trim( $x['idproceso_requi'] );
              
              $cobjetos2 = 'fileArchivo_'.trim( $x['idproceso_requi'] );
              
              $cobjetos3 = 'arc_'.trim( $x['idproceso_requi'] );
              
              $vinculo = 'vinculo_'.trim( $x['idproceso_requi'] );
              
              $cumple  = trim($x['cumple'] );
              $archivo = trim($x['archivo'] );
              
              if ($cumple == 'S'){
                  echo '$("#'.$cobjetos1.'")'.".prop('checked', true);";
                  
              }else{
                  echo '$("#'.$cobjetos1.'")'.".prop('checked', false);";
              }
              
              
              if ( !empty($archivo)) {
                  echo '$("#'.$cobjetos2.'").val("'.$archivo.'");';
                  echo '$("#'.$cobjetos3.'").val("'.$archivo.'");';
                  
                  echo '$("#'.$vinculo.'").attr("href", '.'"'.$folder.$archivo.'"'.');';
                  
                  
              }
          }
          echo '</script>';
          
      }
      
 }   
 
 
   $gestion   = 	new componente;
  
   $id            		= $_GET['idproceso'];
   
   $tarea            	= $_GET['tarea'];
   
   $idcaso	            = $_GET['idcaso'];
   
   $gestion->Formulario( $id ,$tarea,$idcaso);
   
   $gestion->pone_variables( $idcaso  );
   
   $gestion->pone_requisitos( $idcaso  );

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
 
	  
</script>     