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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
               
            	  jQuery('#result').html(data.resultado);
 				  jQuery( "#result" ).fadeOut( 1600 );
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  jQuery("#idpre_estructura").val(data.id );
              	            
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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-estructura.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
        $datos  = array();
         
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
    
    
                $this->BarraHerramientas();
                
                
                $this->obj->text->text('Id',"number" ,'idpre_estructura' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                  
                $this->obj->text->text('Anio',"texto" ,'anio' ,80,80, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Catalogo',"texto" ,'catalogo' ,80,80, $datos ,'','readonly','div-2-4') ;
             
                $this->obj->text->text('Tipo',"texto" ,'tipo' ,80,80, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Campo',"texto" ,'campo' ,80,80, $datos ,'','readonly','div-2-4') ;

                $this->obj->text->text('Etiqueta',"texto" ,'etiqueta' ,80,80, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Lista',"texto" ,'lista' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Elemento',"texto" ,'elemento' ,80,80, $datos ,'','readonly','div-2-4') ;
                
                
     
                $this->obj->text->text('Orden',"number" ,'orden' ,80,80, $datos ,'required','','div-2-4') ;
                
                 
                $MATRIZ = array(
                    'S'    => 'Si',
                    'N'    => 'No'
                );
                $this->obj->list->lista('Esigef',$MATRIZ,'esigef',$datos,'','','div-2-4');
                
                
                $MATRIZ = array(
                    'S'    => 'Si',
                    'N'    => 'No'
                );
                $this->obj->list->lista('Habilitado',$MATRIZ,'estado',$datos,'','','div-2-4');
                
                
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	
   	
    $ToolArray = array( 
               
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
    		
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
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