<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
             	 jQuery('#result').html(data);

            	 jQuery( "#result" ).fadeOut( 1600 );

            	 jQuery("#result").fadeIn("slow");
            
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php';   /*Incluimos el fichero de la clase objetos*/
    require '../../kconfig/Set.php';        /*Incluimos el fichero de la clase objetos*/
  
    /**
     Clase contenedora para la creacion del formulario de visualizacion
     @return
     **/
    
    class componente{
   
      private $obj;
      private $bd;
      private $set;
      
      private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
    
      /**
       Constructor de la clase  del formulario de busquedas
       @return
       **/ 
      function componente(){
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
     
                $this->evento_form = '../model/Model-cli_ingreso.php';        
             
      }
 
      /**
       Constructor de la clase  del formulario de ingreso de datos
       @return
       **/ 
      function Formulario( ){
      
         $this->set->_formulario( $this->evento_form,'inicio');  
 
         $datos = array();
        
         $evento = '';
         
         $tipo     =  $this->bd->retorna_tipo();
         $MATRIZ_A =  $this->obj->array->catalogo_tpIdProv();
         $MATRIZ_B =  $this->obj->array->catalogo_naturaleza();
         $MATRIZ_C =  $this->obj->array->catalogo_activo();
         $MATRIZ_D =  $this->obj->array->catalogo_modulo_ciu();
        
                $this->BarraHerramientas();
                
                
                $this->obj->list->listae('identificacion',$MATRIZ_A,'tpidprov',$datos,'required','',$evento,'div-2-4');
                
                $this->obj->text->text('Nro.Identificacion',"texto",'idprov',13,13,$datos,'required','','div-2-4') ;
                
                $this->obj->list->listae('Naturaleza',$MATRIZ_B,'naturaleza',$datos,'required','',$evento,'div-2-4');
                
                $this->obj->list->listae('Estado',$MATRIZ_C,'estado',$datos,'required','',$evento,'div-2-4');
                 
                $this->obj->list->listae('Tipo',$MATRIZ_D,'modulo',$datos,'','',$evento,'div-2-4');
                
                $resultado = $this->bd->ejecutar_catalogo('canton');
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text_yellow('Razon Social',"texto",'razon',100,100,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text_yellow('Direccion',"texto",'direccion',80,80,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text_blue('Email',"email",'correo',40,45,$datos,'required','','div-2-4') ;
                
                
                $this->obj->text->text('Telefono',"tel",'telefono',40,45,$datos,'required','','div-2-4') ;
                $this->obj->text->text('Movil',"tel",'movil',40,45,$datos,'required','','div-2-4') ;
                
                  
                $this->set->div_label(12,'Contacto');
                
                $this->obj->text->text('Contacto ',"texto",'contacto',40,45,$datos,'required','','div-2-4') ;
                $this->obj->text->text('Email',"email",'ccorreo',40,45,$datos,'required','','div-2-4') ;
                
                
                $this->obj->text->text('Telefono',"tel",'ctelefono',40,45,$datos,'required','','div-2-4') ;
                $this->obj->text->text('Movil',"tel",'cmovil',40,45,$datos,'required','','div-2-4') ;
               
                      
               $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   /**
    Funcion para desplegar la barra de herramientas guardar, nuevo, edicion y procesos en el formulario
    @return
    **/ 
   function BarraHerramientas(){
 
     $eventoi = "javascript:GenerarRuc()";
    
   
         $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Cambiar a proveedor ', evento =>$eventoi,  grafico => 'glyphicon glyphicon-user' ,  type=>"button")
                );
                  
        $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
}

//------------------------------------------------------------------------
// Llama de la clase para creacion de formulario de busqueda
//------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>