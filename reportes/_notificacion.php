<?php 
session_start( );   
  
require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
class _notificacion{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
       private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
       function _notificacion( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                 
                $this->sesion 	 =  $_SESSION['login'];
                
    
       }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Formulario( $modulo,$tramite ){

 
          $datos = array();
          
          $datos['modulo']  = $modulo;
          $datos['tramite'] = $tramite;
 
          $this->obj->text->editor('<b>Comentario/Mensaje</b>','tarea',3,250,250,$datos,'','','div-2-10');
          
          $this->obj->text->textautocomplete('<b>Para</b>',"texto",'nombre_funcionario',40,45,$datos,'required','','div-2-7');
          
          $this->obj->text->text('Identificacion','texto','responsable',10,10,$datos ,'required','readonly','div-0-3') ;
          
          
          $this->obj->text->text('Modulo','texto','modulo',10,10,$datos ,'required','readonly','div-2-10') ;
          $this->obj->text->text('Tramite','texto','tramite',10,10,$datos ,'required','readonly','div-2-10') ;
      
         
   }
 
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
     
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new _notificacion;
  
  $modulo 				=     $_GET["a"];
  
  $tramite 			=     $_GET["id"];
  
  
  $gestion->Formulario($modulo,$tramite );
  
 ?>
 <script src="../app/js/bootstrap3-typeahead.min.js"></script>  
 <script>

  jQuery.noConflict(); 
	 
   jQuery('#nombre_funcionario').typeahead({
  	    source:  function (query, process) {
          return $.get('../kplanificacion/model/AutoCompleteCIU.php', { query: query }, function (data) {
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
  											url:   '../kplanificacion/model/AutoCompleteIDCIU.php',
  											type:  'GET' ,
  											beforeSend: function () {
  												$("#responsable").val('...');
  											},
  											success:  function (response) {
  												$("#responsable").val(response);  // $("#cuenta").html(response);
  													  
  											} 
  									});
  	 
      });
 	 </script>


 
  
 
