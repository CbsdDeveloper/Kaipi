<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo33' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarAntecedente').html( data  );

               jQuery( "#guardarAntecedente" ).fadeOut( 1600 );

               jQuery("#guardarAntecedente").fadeIn("slow");

               jQuery("#action_01").val("editar");
                
               
               GrillaAntecedentes(-1);

         
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
  
    class Controller_me_atencion03{
 
  
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
      function Controller_me_atencion03( ){
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
 
                $this->set->div_label(12,'<B>  ANTECEDENTES PERSONALES</B>');	 


                $this->obj->text->text_yellow('Codigo',"number" ,'id_atencion_per' ,80,80, $datos ,'required','readonly','div-2-10') ;
                
                $MATRIZ_S = array(
                    'APP'    => 'APP',
                    'AQX'    => 'AQX',
                    'ALERGIAS'    => 'ALERGIAS',
                    'OTROS'    => 'OTROS'
                );
                
                 
                $this->obj->list->lista('Tipo',$MATRIZ_S,'pe_tipo',$datos,'required','','div-2-10'); 
                
                $this->obj->text->editor('Detalle','pe_detalle',3,250,250,$datos,'','','div-2-10');

 
                $this->obj->text->texto_oculto("action_01",$datos); 

                $this->obj->text->texto_oculto("id_atencion_01",$datos); 
          
  
                                
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new Controller_me_atencion03;
  
   
  $gestion->Formulario( );
  
 ?>
  