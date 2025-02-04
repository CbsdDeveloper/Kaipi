<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#guardarRequisito').html(data);
            
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';    
 	
    require '../../kconfig/Obj.conf.php'; 
    
    require '../../kconfig/Set.php'; 
  
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
          
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
   
     function Formulario( ){
      
     
     		$this->set->div_label(12,'<h6> Requisitos del proceso<h6>');
     	 	
     		     $datos  = array();
                
                 $this->obj->text->text_blue('Requisito',"texto",'requisito',150,150,$datos,'required','','div-3-9') ;
                 
                 $evento = ' ';
                 
                 $MATRIZ = array(
                 		'Copia'    => 'Copia',
                		'Original'    => 'Original',
                 		'Documento Interno'    => 'Documento Interno',
                 		'Correo Electronico'    => 'Correo Electronico'
                );
                
                $this->obj->list->listae('Tipo ',$MATRIZ,'tipo_req',$datos,'required','',$evento,'div-3-9');
       
                $MATRIZ = array(
                		'S'    => 'SI',
                		'N'    => 'NO',
                );
                $this->obj->list->listae('Adjuntar',$MATRIZ,'obligatorio',$datos,'required','',$evento,'div-3-9');
                
                
                $MATRIZ = array(
                		'Alta'    => 'Alta',
                		'Media'    => 'Media',
                		'Bajo'    => 'Bajo'
                );
                $this->obj->list->listae('Prioridad',$MATRIZ,'prioridad',$datos,'required','',$evento,'div-3-9');
 
                $MATRIZ = array(
                		'S'    => 'SI',
                		'N'    => 'NO',
                );
                $this->obj->list->listae('Activo',$MATRIZ,'estado_req',$datos,'required','',$evento,'div-3-9');
               
                 
                
	         $this->obj->text->texto_oculto("action1",$datos); 
	                
	         $this->obj->text->texto_oculto("idproceso1",$datos); 
	         
	         $this->obj->text->texto_oculto("idproceso_requi",$datos); 
	         
	  //       $this->obj->text->text('Secuencia',"number",'idproceso_requi',40,45,$datos,'','readonly','div-3-9') ;
  
      
   }
 
   //----------------------------------------------
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
 
  