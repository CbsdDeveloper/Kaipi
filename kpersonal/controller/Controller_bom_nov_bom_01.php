<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
        // InjQueryerceptamos el evento submit
         jQuery('#fo_carro' ).submit(function() {
               // Enviamos el formulario usando AJAX
             jQuery.ajax({
                 type: 'POST',
                 url: jQuery(this).attr('action'),
                 data: jQuery(this).serialize(),
                 // Mostramos un mensaje con la respuesta de PHP
                 success: function(data) {
                     
        
                       jQuery('#guardarDocumento').html( data  );
        
                       jQuery( "#guardarDocumento" ).fadeOut( 1600 );
        
                       jQuery("#guardarDocumento").fadeIn("slow");
        
                       jQuery("#action_03").val("editar");

                       var editar = $("#action_03").val();

                       if ( editar == 'editar'){

                    	   	  BusquedaCarro();
                    	   
                    	     $("#action_03").val("editar");
                       } 
        
                  

 
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
  
    class Controller_bom_nov_bom_01{
 
  
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
      function Controller_bom_nov_bom_01( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
 
      }
      
      //---------------------------------------
      
     function Formulario( ){
      
         
       
        $datos      = array();
 
          
          
       
                $this->set->div_label(12,'<B>  ACTIVIDADES REALIZADAS</B>');	 

              
                $this->obj->text->text_blue('Actividad',"texto" ,'novedad_c' ,250,250, $datos ,'required','','div-2-10','Actividad vehiculo','S') ;
                
                $this->obj->text->text_blue('Orden',"texto" ,'orden' ,5,5, $datos ,'required','','div-2-2','Codigo Jefe','S') ;
                 
                $this->obj->text->textautocomplete('Operador',"texto",'nombre_funcionario',150,150,$datos,'required','','div-0-8','S');
                
                 
                $this->obj->text->textautocomplete('Vehiculo',"texto",'nombre_bien',100,100,$datos,'required','','div-2-10','S');
                
                         
                $this->set->div_label(12,'<B>  SEGUIMIENTO</B>');	 
                
                
                $this->obj->text->text_yellow('Salida',"time" ,'salida' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text_yellow('Km Salida',"entero" ,'km_salida' ,80,80, $datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->text_blue('Retorna',"time" ,'retorna' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text_blue('Km Retorna',"entero" ,'km_retorna' ,80,80, $datos ,'required','','div-2-4') ;
                
                 
                $this->obj->text->texto_oculto("action_03",$datos); 

                $this->obj->text->texto_oculto("id_mov_carro",$datos); 
                
                $this->obj->text->texto_oculto("id_chofer",$datos); 
                
                $this->obj->text->texto_oculto("idbien",$datos); 
         
        
               
                
  
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new Controller_bom_nov_bom_01;
  
   
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
  											url:   '../model/AutoCompleteIDCIU.php',
  											type:  'GET' ,
  											beforeSend: function () {
  												$("#id_chofer").val('...');
  											},
  											success:  function (response) {
  												$("#id_chofer").val(response);  
  													  
  											} 
  									});
  	 
      });

 //--------------------------------------------------------------------------------

   jQuery('#nombre_bien').typeahead({
 	    source:  function (query, process) {
         return $.get('../model/AutoComplete_carro.php', { query: query }, function (data) {
         		console.log(data);
         		data = $.parseJSON(data);
 	            return process(data);
 	        });
 	    } 
 	}); 

   jQuery("#nombre_bien").focusout(function(){
	  	 
	  	 var itemVariable = $("#nombre_bien").val();  
	  	 
	          		var parametros = {
	  											"itemVariable" : itemVariable 
	  									};
	  									 
	  									$.ajax({
	  											data:  parametros,
	  											url:   '../model/AutoComplete_IdBien.php',
	  											type:  'GET' ,
	  											beforeSend: function () {
	  												$("#idbien").val('...');
	  											},
	  											success:  function (response) {
	  												$("#idbien").val(response);  
	  													  
	  											} 
	  									});
	  	 
	      });
 	 </script>
 