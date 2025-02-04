<script type="text/javascript" src="formulario_result.js"></script> 
<?php 
    
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
 
    
    class Controller_me_atencion{
 
  
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
      function Controller_me_atencion( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model_me_atencion.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
      
 
         $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
         $datos = array();
 
                
                $this->BarraHerramientas();
                
           
                
                
                $this->set->div_panel6('<h6> PASO 1.- INFORMACION PRINCIPAL<h6>');
                
                
                
                
                    $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','readonly','div-2-10') ;
                    $this->obj->text->text('Atención',"date" ,'fatencion' ,80,80, $datos ,'required','readonly','div-2-4') ;
                    
                    $this->obj->text->text('Hora',"time" ,'hora' ,80,80, $datos ,'required','readonly','div-2-4') ;
                    
                     
                    $this->obj->text->textautocomplete('<B>Paciente</B>',"texto",'nombre_funcionario',150,150,$datos,'required','','div-2-10','S');
                    
                    $this->obj->text->text('Edad',"texto" ,'edad' ,80,80, $datos ,'required','readonly','div-2-4') ;
                    
                    $this->obj->text->text('Tipo Sangre',"texto" ,'tsangre' ,80,80, $datos ,'required','readonly','div-2-4') ;
                    
                    $this->obj->text->editor('Motivo','motivo',3,550,550,$datos,'required','','div-2-10') ;
                    
                    
                    $this->obj->text->texto_oculto("id_prov",$datos); 
                
                
                $this->set->div_panel6('fin');
                
                
                $this->set->div_panel6('<h6> PASO 2.- SINTOMA/DIAGNOSTIVO<h6>');
                
                        $this->obj->text->text('Atencion',"number" ,'id_atencion' ,80,80, $datos ,'required','readonly','div-2-4') ;
                        $this->obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'required','readonly','div-2-4') ;
                
                        $this->obj->text->editor('Sintomas','sintomas',5,550,550,$datos,'required','','div-2-10') ;
                        
                         
                        $this->obj->text->editor('Diagnostico','diagnostico',4,550,550,$datos,'required','','div-2-10') ;
                        
                            
                
                
                $this->set->div_panel6('fin');
                
                 
         $this->obj->text->texto_oculto("action",$datos); 
        
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
  
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       $formulario_reporte = '../../reportes/ficha_empleado?';
       
       $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
       
       $evento =  "javascript:valida()";
       
       $ToolArray = array(
           array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
           array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
           array( boton => 'AUTORIZAR SOLICITUD DE ATENCION MEDICA', evento =>$eventoi,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_success"),
           array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
           array( boton => 'Imprimir Receta', evento =>$evento,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info"),
       );
       
       $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new Controller_me_atencion;
 
   $gestion->Formulario( );

 ?>
<script src="../../app/js/bootstrap3-typeahead.min.js"></script>  
 <script>

  jQuery.noConflict(); 
	 
   jQuery('#nombre_funcionario').typeahead({
  	    source:  function (query, process) {
          return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
          		console.log(data);
          		data = $.parseJSON(data);
  	            return process(data);
  	        });
  	    } 
  	});


  	
   jQuery("#nombre_funcionario").focusout(function(){
		 
		 var itemVariable = $("#nombre_funcionario").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDpaciente.php',
												type:  'GET' ,
												dataType: "json",
												success:  function (response) {
													
														 $("#id_prov").val( response.a );  
 	 
														 $("#edad").val( response.b );  
														 $("#tsangre").val( response.c );  
														 
														    
														    
												} 
										});
		 
	    });
//-----------------------------------------------------------------------------
 

   
 </script>