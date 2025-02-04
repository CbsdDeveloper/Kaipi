<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo23' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarTarea').html( data  );

               jQuery( "#guardarTarea" ).fadeOut( 1600 );

               jQuery("#guardarTarea").fadeIn("slow");

               jQuery("#action_03").val("editar");

              VisorTareas ( 0 );
               
           
         
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
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  date('Y-m-d');
 
      }
      
      //---------------------------------------
      
     function Formulario( ){
      
         
       
        $datos      = array();
 
         
          
        $this->obj->text->texto_oculto("action_03",$datos);
        
        $this->obj->text->texto_oculto("idtarea_seg1",$datos); 
        $this->obj->text->texto_oculto("idtarea1",$datos); 
        $this->obj->text->texto_oculto("seg_secuencia1",$datos); 
        $this->obj->text->texto_oculto("seg_proceso1",$datos); 
        
        
        $datos['seg_estado1'] = 'solicitado';
        
        $this->obj->text->texto_oculto("seg_estado1",$datos);
        
 
        $this->obj->text->text_blue('Fecha Inicio',"date" ,'seg_fecha1' ,80,80, $datos ,'required','','div-2-10') ;
        
        $this->obj->text->editor('Justificación','seg_tarea_seg1',3,250,250,$datos,'required','','div-2-10');
         
       
  
      
   }
 
  }
  ///------------------------------------------------------------------------
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  