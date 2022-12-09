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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
            	$this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-teletrabajo_jefe.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
        
        $tipo = $this->bd->retorna_tipo();

        

 
                $this->BarraHerramientas();
       
                $this->set->div_panel6('<b> DATOS DE FUNCIONARIOS </b>');

                 
                            $this->obj->text->text('Referencia',"number",'id_teleasigna',0,10,$datos,'','readonly','div-2-4') ; 

                            $this->obj->text->text('Identificación',"texto",'idprov',20,15,$datos,'required','readonly','div-2-4') ; 
                    
                            $this->obj->text->text_yellow('Funcionario',"texto",'razon',40,45,$datos,'required','readonly','div-2-10');
                             
                            $this->obj->text->text('Cargo',"texto",'cargo',40,45,$datos,'required','readonly','div-2-4');
                        
                            $this->obj->text->text('Unidad',"texto",'unidad',40,45,$datos,'required','readonly','div-2-4');
                        
 
                    $this->set->div_panel6('fin');
                    
                    
                    $this->set->div_panel6('<b> ACTIVIDADES A DESARROLLAR  </b>');
                 
                    
                        $this->obj->text->text_yellow('Inicio',"date",'fecha_inicio',15,15,$datos,'required','','div-2-4');
                        $this->obj->text->text_yellow('Fin',"date",'fecha_fin',15,15,$datos,'required','','div-2-4');

                        $this->obj->text->editor('Actividad','actividades',4,45,300,$datos,'required','','div-2-10') ;
                
                     
                    $this->set->div_panel6('fin');
                              
                          
                    
               
                    $this->set->div_panel12('<b> LISTA DE ACTIVIDADES DE LA SEMANA </b>');
                    
                              
                    echo  '<div id="VisorActividades">  </div>'; 
                
                        
                    
                    
                    $this->set->div_panel12('fin');
                    
         $this->obj->text->texto_oculto("action",$datos); 

         $this->obj->text->texto_oculto("id_teletrabajo",$datos); 

         $this->obj->text->texto_oculto("idprov_jefe",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 //  $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
   //----------------------------------------------
   function combodb(){
       
       $datos = array();
    
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias 
                  WHERE sesion=".$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)." 
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipo',$datos);
 
 
  }   
    //----------------------------------------------
   function combodbA(){
    
       $datos = array();
       
        $sql = "SELECT idprov as codigo, razon as nombre 
                  FROM view_crm_incidencias  
                  group by idprov,razon order by razon";
		
        echo $this->bd->combodb($sql,'tipoa',$datos);
 
 
  }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
 
   $gestion->Formulario( );

 ?>
<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#brazon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

 // nombre,, cedula,email
 
 jQuery("#brazon").focusout(function(){
	 
	 var itemVariable = $("#brazon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDMultiple.php',
											type:  'GET' ,
											  dataType: 'json',  
											beforeSend: function () {
												$("#cedula").val('...');
											},
											success:  function (response) {
												$("#cedula").val(response.a);   
												$("#apellido").val(response.b);  
												$("#nombre").val(response.c);  
												$("#email").val(response.d);  
												$("#nomina").val('S');  

												$("#login").val(response.e);  
												$("#idciudad").val(response.f);  
												$("#direccion").val(response.g);  
												$("#telefono").val(response.h);  
												$("#movil").val(response.i);  
												$("#id_departamento").val(response.j); 
 												
											} 
									});
 			  	 
					                          
					                          
									 
    });
 
 //----------------------------------------------
  
  
  
</script>
  