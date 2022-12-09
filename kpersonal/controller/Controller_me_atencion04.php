<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo44' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarFamilia').html( data  );

               jQuery( "#guardarFamilia" ).fadeOut( 1600 );

               jQuery("#guardarFamilia").fadeIn("slow");

               jQuery("#action_02").val("editar");
                
               
               GrillaFamilia(-1);

         
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
  
    class Controller_me_atencion04{
 
  
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
      function Controller_me_atencion04( ){
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
 
                $this->set->div_label(12,'<B>  ANTECEDENTES FAMILIARES</B>');	 


 

                $this->obj->text->text_yellow('Codigo',"number" ,'id_atencion_fami' ,80,80, $datos ,'required','readonly','div-2-10') ;
                
                $MATRIZ_S = array(
                    'Abuelos'    => 'Abuelos',
                    'Padre'    => 'Padre',
                    'Madre'    => 'Madre',
                    'Tios'    => 'Tios',
                    'Hermanos'    => 'Hermanos',
                    'Primos'    => 'Primos',
                    'Hijos'    => 'Hijos'
                );
                
                 
                $this->obj->list->lista('Parentesco',$MATRIZ_S,'fa_parentesto',$datos,'required','','div-2-10'); 
                
                $this->obj->text->editor('Antecedente','fa_detalle',3,250,250,$datos,'','','div-2-10');
  
                $this->obj->text->texto_oculto("action_02",$datos); 

                $this->obj->text->texto_oculto("id_atencion_02",$datos); 
          
  
                                
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new Controller_me_atencion04;
  
   
  $gestion->Formulario( );
  
 ?>
  