<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_micombustible01{
 
  
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
      function Controller_micombustible01( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
           
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){

     
         $tipo   = $this->bd->retorna_tipo();
         $datos  = array();
      
         
         $this->set->div_panel12('<b> CONTROL DE COMBUSTIBLE </b>');
         
         $this->obj->text->text('Codigo',"number" ,'id_combus' ,80,80, $datos ,'required','readonly','div-3-9') ;
         
         
         $this->obj->text->text_blue('<b>Estado</b>','texto','estado',10,10,$datos ,'required','readonly','div-3-3') ;
 
         $this->obj->text->text_yellow('Km.Actual',"entero" ,'u_km_inicio' ,80,80, $datos ,'required','','div-3-3') ;
         
         
         $this->obj->text->textautocomplete('<b>OPERADOR</b>',"texto",'nombre_funcionario',40,45,$datos,'required','','div-3-9');
         
         $this->obj->text->text('Identificacion','texto','id_operador',10,10,$datos ,'required','readonly','div-3-3') ;
         
         $this->obj->text->text('Lugar Salida',"texto" ,'ubicacion_salida' ,80,80, $datos ,'required','','div-3-3') ;
         
       
         
         $MATRIZ = array(
             'GALON'    => 'GALON',
             'CANECA'    => 'CANECA'
         );
         $evento     ='Onchange="habilita_campo(this.value)"';
         $this->obj->list->listae('Unidad',$MATRIZ,'medida',$datos,'','',$evento,'div-3-3');
         
         $this->obj->text->text_blue('Nro.Canecas',"entero" ,'cantidad_ca' ,80,80, $datos ,'','readonly','div-3-3') ;
         
         
        
         
         $evento     ='Onchange="monto_combustible(this.value)"';
         $resultado = $this->bd->ejecutar_catalogo('COMBUSTIBLE','texto');
         
         
         $this->obj->list->listadbe($resultado,$tipo,'Combustible','tipo_comb',$datos,'required','',$evento,'div-3-9') ;
         
         $this->obj->text->text_yellow('Costo',"float" ,'costo' ,80,80, $datos ,'required','','div-3-3') ;
         
         $this->obj->text->text_blue('Galones(*)',"number" ,'cantidad' ,80,80, $datos ,'required','','div-3-3') ;
         
         $this->obj->text->text('IVA $',"float" ,'iva' ,80,80, $datos ,'','readonly','div-3-3') ;
         
         $this->obj->text->text_yellow('Galones $',"float" ,'total_consumo' ,80,80, $datos ,'','readonly','div-3-3') ;
         
         $this->obj->text->text('Total $',"float" ,'total_iva' ,80,80, $datos ,'','readonly','div-3-9') ;
         
         
         $this->set->div_panel12('fin');
        
   }




   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new Controller_micombustible01;
  
   
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
  												$("#id_operador").val('...');
  											},
  											success:  function (response) {
  												$("#id_operador").val(response);   
  													  
  											} 
  									});
  	 
      });
 	 </script>
 
  