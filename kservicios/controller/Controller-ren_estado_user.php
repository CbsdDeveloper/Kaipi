<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
 	
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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
    
       }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      
     function Formulario( ){
      
 
         
         $datos = array();
         
  
 
                
                $this->obj->text->textautocomplete('Identificacion','texto','idprov',13,13,$datos ,'required',' ','div-0-4') ;
                
                
                 $cboton2 = 'Contribuyente';
                 
                
                $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'required','','div-0-8');
                
                
                $this->obj->text->text('Email','texto','correo',120,120,$datos ,'','readonly','div-0-4') ;
                $this->obj->text->text('Direccion','texto','direccion',120,120,$datos ,'','readonly','div-0-8') ;
                
              
                
                
                $this->obj->text->texto_oculto("id_par_ciu",$datos); 
                
 
                
                 
  
         
         $this->set->_formulario('-','fin'); 
 
   }
  
  //----------------------------------------------------......................-------------------------------------------------------------
 
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
 
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 <script type="text/javascript">

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
 

 
 $("#razon").focusin(function(){
	 
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
    													 
    													 $("#correo").val( response.b );  

    													 $("#id_par_ciu").val( response.c ); 

    													 $("#direccion").val( response.d ); 
    													 
    											} 
    									});
	 
    });


 $("#idprov").focusin(function(){
	 
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
											 
											 $("#correo").val( response.b );  

											 $("#id_par_ciu").val( response.c ); 

											 $("#direccion").val( response.d ); 
									} 
							});

});
 
</script>
  