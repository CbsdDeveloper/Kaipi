<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo5' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarMaterial').html( data  );

               jQuery( "#guardarMaterial" ).fadeOut( 1600 );

               jQuery("#guardarMaterial").fadeIn("slow");

               jQuery("#action_04").val("editar");

               
               
               GrillaMaterial(-1);

         
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
 
       
        
        
        $MATRIZ_B = array(
            'E.H.A' => 'E.H.A',
            'EQUIPOS'    => 'EQUIPOS',
            'MATERIALES'    => 'MATERIALES',
            'HERRAMIENTAS'    => 'HERRAMIENTAS'
        );
        
     

                $this->set->div_label(12,'<B>NOVEDADES ADICIONALES</B>');	 


                $this->obj->text->text_yellow('Codigo',"number" ,'id_bom_mate' ,80,80, $datos ,'required','readonly','div-2-10') ;
 
  
                $this->obj->text->text_blue('Cantidad',"texto" ,'cantidad' ,2,2, $datos ,'required','','div-2-4') ;
                $this->obj->list->lista('<b>Tipo</b>',$MATRIZ_B,'tipo_m',$datos,'required','','div-2-4'); 
                
          
                
                $this->obj->text->editor('Actividad realizada','actividad_m',3,250,250,$datos,'','','div-2-10');

          
             
                $this->obj->text->texto_oculto("action_04",$datos); 

                $this->obj->text->texto_oculto("id_bita_bom_04",$datos); 
         
        
               
                
  
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  