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
             

               jQuery('#guardarActividad').html( data  );

               jQuery( "#guardarActividad" ).fadeOut( 1600 );

               jQuery("#guardarActividad").fadeIn("slow");

               jQuery("#action_02").val("editar");
                
               
               GrillaActividad(-1);

         
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
 
         
 

                $this->set->div_label(12,'<B>  ACTIVIDADES REALIZADAS</B>');	 


                $this->obj->text->text_yellow('Codigo',"number" ,'id_bom_acti' ,80,80, $datos ,'required','readonly','div-2-10') ;
 
  
                
                $MATRIZ_S = array(
                    'SIN NOVEDAD DIA'    => 'SIN NOVEDAD DIA',
                    'ATENCION EMERGENCIA'    => 'ATENCION EMERGENCIA',
                    'ATENCION PROCESOS ADMINISTRATIVOS'    => 'ATENCION PROCESOS ADMINISTRATIVOS',
                    'ATENCION CAPACITACION'    => 'ATENCION CAPACITACION',
                    'ATENCION GRUPOS ATENCION PRIORITARIA'    => 'ATENCION GRUPOS ATENCION PRIORITARIA',
                    'APOYO SEGUIMIENTO INSPECCION'    => 'APOYO SEGUIMIENTO INSPECCION',
                    'INSTALACIONES-MOBILIARIO'    => 'INSTALACIONES-MOBILIARIO',
                    'INSTALACIONES-COCINA'    => 'INSTALACIONES-COCINA',
                    'INSTALACIONES-EQUIPOS'    => 'INSTALACIONES-EQUIPOS'
                );
                
           
                    
                 
                $this->obj->list->lista('Actividad',$MATRIZ_S,'tipo_actividad',$datos,'required','','div-2-10'); 
                
                $this->obj->text->editor('Actividad realizada','actividad_d',3,250,250,$datos,'','','div-2-10');

 
                $this->obj->text->texto_oculto("action_02",$datos); 

                $this->obj->text->texto_oculto("id_bita_bom_02",$datos); 
         
        
               
                
  
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
  