<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo22' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarCompras').html( data  );

               jQuery( "#guardarCompras" ).fadeOut( 1600 );

               jQuery("#guardarCompras").fadeIn("slow");

               jQuery("#action_02").val("editar");

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
  
    class Controller_tarea_seg01{
 
  
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
      function Controller_tarea_seg01( ){
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
 
         
      //  $array = $this->bd->__user($this->sesion);
         
        $this->obj->text->texto_oculto("action_02",$datos);
        
        $this->obj->text->texto_oculto("idtarea_seg",$datos); 
        $this->obj->text->texto_oculto("idtarea",$datos); 
        $this->obj->text->texto_oculto("idpac",$datos); 
        $this->obj->text->texto_oculto("seg_secuencia",$datos); 
        $this->obj->text->texto_oculto("seg_proceso",$datos); 
        
        $datos['seg_estado'] = 'solicitado';
        
        $this->obj->text->texto_oculto("seg_estado",$datos); 
         
    
 
        $this->obj->text->text_blue('Fecha Inicio',"date" ,'seg_fecha' ,80,80, $datos ,'required','','div-2-10') ;
        
        $this->obj->text->editor('Justificación','seg_tarea_seg',3,250,250,$datos,'required','','div-2-10');
         
        $this->obj->text->text_yellow('Monto Solicitado',"number" ,'seg_solicitado' ,80,80, $datos ,'required','','div-2-4') ;
 
   
        $this->obj->text->text('Saldo Disponible',"number" ,'saldo_tarea' ,80,80, $datos ,'','readonly','div-2-4') ;       
  
      
   }
 
  }
  ///------------------------------------------------------------------------
  
  $gestion   = 	new Controller_tarea_seg01;
  
   
  $gestion->Formulario( );
  
 ?>
  