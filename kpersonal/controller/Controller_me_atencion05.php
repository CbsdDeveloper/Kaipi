<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo45' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarReceta').html( data  );

               jQuery( "#guardarReceta" ).fadeOut( 1600 );

               jQuery("#guardarReceta").fadeIn("slow");

               jQuery("#action_03").val("editar");
                
               
               GrillaReceta(-1);

         
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
  
    class Controller_me_atencion05{
 
  
      private $obj;
      private $bd;
      private $set;
 
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Controller_me_atencion05( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
        
                
        
   
             
      }
      
      //---------------------------------------
      
     function Formulario( ){
      
         
       
                $datos      = array();
 
                $this->set->div_label(12,'<B>  MEDICAMENTO RECETADO</B>');	 
 

              $this->obj->text->textautocomplete('<B>Medicamento</B>',"texto",'nombre_medicamento',150,150,$datos,'required','','div-2-10','S');


              $this->obj->text->editor('Indicaciones','indicaciones',3,250,250,$datos,'required','','div-2-10');


              $this->obj->text->text('Cantidad',"entero" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;
                
  
                $this->obj->text->texto_oculto("action_03",$datos); 

                $this->obj->text->texto_oculto("id_atencion_03",$datos); 
                $this->obj->text->texto_oculto("id_id_medicina",$datos); 
                $this->obj->text->texto_oculto("id_atencion_rece",$datos); 
  
               
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new Controller_me_atencion05;
  
   
  $gestion->Formulario( );
  
 ?>
 <script>

  jQuery.noConflict(); 
	 
   jQuery('#nombre_medicamento').typeahead({
  	    source:  function (query, process) {
          return $.get('../model/AutoCompleteReceta.php', { query: query }, function (data) {
          		console.log(data);
          		data = $.parseJSON(data);
  	            return process(data);
  	        });
  	    } 
  	});


  	
   jQuery("#nombre_medicamento").focusout(function(){
		 
		 var itemVariable = $("#nombre_medicamento").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDreceta.php',
												type:  'GET' ,
												dataType: "json",
												success:  function (response) {
													
														 $("#id_id_medicina").val( response.a );  
 	 
														 $("#ViewUso").html( response.b );  
 														 
														    
														    
												} 
										});
		 
	    });
//-----------------------------------------------------------------------------
 

   
 </script>