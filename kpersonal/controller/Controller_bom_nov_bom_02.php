<script >// <![CDATA[

jQuery.noConflict(); 
 
 jQuery(document).ready(function() {
       
// InjQueryerceptamos el evento submit
 jQuery(' #fo5_emer' ).submit(function() {
       // Enviamos el formulario usando AJAX
     jQuery.ajax({
         type: 'POST',
         url: jQuery(this).attr('action'),
         data: jQuery(this).serialize(),
         // Mostramos un mensaje con la respuesta de PHP
         success: function(data) {
             

               jQuery('#guardarEmergencia').html( data  );

               jQuery( "#guardarEmergencia" ).fadeOut( 1600 );

               jQuery("#guardarEmergencia").fadeIn("slow");

               jQuery("#action_02").val("editar");

               
         

         
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
  
    class Controller_bom_nov_bom_02{
 
  
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
      function Controller_bom_nov_bom_02( ){
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
 
         
          
         
        $MATRIZ_A = array(
            'auxilio'    => 'Auxilio',
            'incendio'    => 'Incendio'
        );
        
        $MATRIZ_C = array(
            'Laborable'    => 'Laborable',
            'Festivo'    => 'Festivo',
            'Feriado'    => 'Feriado',
            'Fin Semana'    => 'Fin Semana'
        );
        
        $MATRIZ_D = array(
            'CR'    => 'CR',
            'Telefono'    => 'Telefono',
            'Personal'    => 'Personal' 
        );
         
        
        $MATRIZ_B = array(
            'Primer Peloton'    => 'Primer Peloton',
            'Segundo Peloton'    => 'Segundo Peloton',
            'Tercer Peloton'    => 'Tercer Peloton',
            'Cuarto Peloton'    => 'Cuarto Peloton',
            'Quinto Peloton'    => 'Quinto Peloton'
        );
        
        
        $this->set->div_label(12,'<B>SOLICITUD DE EMERGENCIA</B>');	 
        
        
        $this->obj->list->lista('<b>Tipo Emergencia</b>',$MATRIZ_A,'tipo_emergencia',$datos,'required','','div-2-10'); 
        
        $this->obj->list->lista('<b>Hoy dia es</b>',$MATRIZ_C,'clasedia',$datos,'required','','div-2-4'); 
        
        $this->obj->list->lista('Forma de Aviso',$MATRIZ_D,'faviso',$datos,'required','','div-2-4'); 
        
        $this->obj->text->text_blue('Especificacion Aviso',"texto" ,'especificacion' ,250,250, $datos ,'required','','div-2-10') ;
        
        $this->obj->text->text_yellow('# CLAVE',"texto" ,'clave' ,80,80, $datos ,'required','','div-2-4','S') ;
         
        $this->set->div_label(12,'<B>EMERGENCIA ATENDIDA POR</B>');	 
        
        $this->obj->list->lista('<b>Peloton/Turno</b>',$MATRIZ_B,'peloton',$datos,'required','','div-2-4'); 
        
        $this->obj->text->text_yellow('Aviso',"time" ,'aviso' ,80,80, $datos ,'required','','div-2-4') ;
        
        $this->set->div_label(12,'<B>DETALLE EMERGENCIA</B>');	 
        
         $this->obj->text->editor('Descripcion Emergencia','descripcion',3,450,450,$datos,'','','div-2-10') ;
        
         
         $this->obj->text->editor('Sector','sector',2,450,450,$datos,'','','div-2-10') ;
         $this->obj->text->editor('Direccion','direccion',2,450,450,$datos,'','','div-2-10') ;
        
        
         
        $this->obj->text->texto_oculto("action_02",$datos); 

         $this->obj->text->texto_oculto("id_em_gestion",$datos); 
         
        
      
   }
 
  }
  ///------------------------------------------------------------------------
 
   
  
  $gestion   = 	new Controller_bom_nov_bom_02;
  
   
  $gestion->Formulario( );
  
 ?>
  