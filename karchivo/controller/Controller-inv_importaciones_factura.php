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
 				
             	 jQuery('#resultFactura').html(data);

            	 jQuery( "#resultFactura" ).fadeOut( 1600 );

            	 jQuery("#resultFactura").fadeIn("slow");
            
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
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-inv_importaciones_factura.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
      
        $titulo = 'Factura';
         
        $this->set->evento_formulario_id( $this->evento_form,'inicio','form' ); // activa ajax para insertar informacion
   
    
 
    
                $this->BarraHerramientas();
                 
                $this->set->div_panel('<b> INFORMACION GENERAL </b>');
                       
                     
                    $this->obj->text->text('Fecha factura',"date" ,'fechafactura' ,80,80,$datos ,'required','','div-2-10') ;
                     $this->obj->text->text('Nro.Factura',"texto" ,'factura' ,20,20,$datos ,'required','','div-2-10') ;
                    $this->obj->text->text('Razon Social',"texto" ,'nombre_factura' ,80,80,$datos ,'required','','div-2-10') ;
                    $this->obj->text->text('Naturaleza',"texto" ,'naturaleza' ,80,80,$datos ,'required','','div-2-10') ;
                    $this->obj->text->text('Iconterm',"texto" ,'iconterm' ,80,80,$datos ,'required','','div-2-10') ;
                    
                    $this->obj->text->text('Valor Factura',"number" ,'valor' ,80,80,$datos ,'required','','div-2-10') ;
                    
                    
              $this->set->div_panel('fin');
             
              
              
              
         $this->obj->text->texto_oculto("action_factura",$datos); 
         
         $this->obj->text->texto_oculto("id_importacionfac",$datos); 
         
         $this->obj->text->texto_oculto("id_importacion_key",$datos); 
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
  
    $eventoi = "javascript:nueva_factura()";
       
    $ToolArray = array( 
        array( boton => 'Nuevo Regitros',    evento =>$eventoi, grafico => 'icon-white icon-plus' ,  type=>"button"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
    $this->obj->boton->ToolMenuDivId($ToolArray,'resultFactura'); 
 
  }  
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
 
  