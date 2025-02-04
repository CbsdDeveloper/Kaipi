<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class Controller_me_atencion01{
    
     
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
    function Controller_me_atencion01( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->set     = 	new ItemsController;
        
        $this->bd	   =	new  Db ;
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroFormulario(){
        
        
        
        $datos= array();
        
        
        echo '<div class="col-md-6">';  

                    $this->set->div_label(12,'<B>  SIGNOS VITALES</B>');
        
                  
                    $this->obj->text->text_yellow('PESO (KG)',"number" ,'peso' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    
                    $this->obj->text->text_blue('ESTATURA (M)',"number" ,'estatura' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    $this->obj->text->text_yellow('T. ARTERIAL',"texto" ,'arterial' ,80,80, $datos ,'required','','div-2-4') ;
                    
                  
                    $this->obj->text->text_blue('F. CARDIACA',"number" ,'cardio' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    
                    $this->obj->text->text_yellow('F. RESPIRATORIA',"number" ,'respiratorio' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text_blue('TEMPERATURA (°C)',"texto" ,'temperatura' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    
                    $this->obj->text->text_yellow('S02',"number" ,'so2' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text_blue('IMC',"number" ,'imc' ,80,80, $datos ,'required','readonly','div-2-4') ;
                    
                    
       
                    echo '<div class="col-md-12" style="padding-top: 5px;">	 <button type="button" onClick="imc_calculo()" class="btn btn-info">Calculo IMC</button>'.  '</div> ';
                    
                    echo '<div class="col-md-12" id="ViewICM"  style="padding-top: 5px;"></div> ';
        
     
         echo '</div><div class="col-md-6">';  
                    
                    $this->set->div_label(12,'<B>  LISTA DE ENFERMEDADES</B>');
         
                    $this->obj->text->textautocomplete('Enfermedad',"texto",'enfermedad',150,150,$datos,'required','','div-2-10','S');

                    
                    echo '<div class="col-md-12" id="ViewEnfermo"  style="padding-top: 5px;"></div> ';
                    

         echo '</div>';  
    }
    
    ///------------------------------------------------------------------------
}

$gestion   = 	new Controller_me_atencion01;


$gestion->FiltroFormulario( );

?>
<script>

  jQuery.noConflict(); 
	 
  
//-----------------------------------------------------------------------------
   jQuery('#enfermedad').typeahead({
  	    source:  function (query, process) {
          return $.get('../model/AutoMe_Enfermedad.php', { query: query }, function (data) {
          		console.log(data);
          		data = $.parseJSON(data);
  	            return process(data);
  	        });
  	    } 
  	});


  	
   jQuery("#enfermedad").focusout(function(){
		 
		 var itemVariable = $("#enfermedad").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDenfermo.php',
												type:  'GET' ,
												dataType: "json",
												success:  function (response) {

													if ( response.a > 0 )  {

   															inserta_enfermedad( response.a,itemVariable ); 		
	 													
															$("#enfermedad").val('');  
													}  
														    
														    
												} 
										});
		 
	    });


   
 </script>