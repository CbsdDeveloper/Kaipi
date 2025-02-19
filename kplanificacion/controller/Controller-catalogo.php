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
                   
                $this->bd     = 	new Db;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-admin_catalogo.php'; 
   
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

        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
           
        $this->BarraHerramientas();
        
    
        
        $sql = "SELECT  IDCATALOGO as CODIGO, NOMBRE
			        FROM SICATALOGO
			        WHERE ESTADO = 'S'";
     
        $evento = '"';
        
        $this->bd->listadbe($sql,'Referencia','IDCATALOGO','required','',$evento,'div-2-10') ;
        
        $this->obj->text->text('IdCodigo','number','IDCATALOGODETALLE','required','readonly','div-2-4') ;
        
        $evento = '';
        $MATRIZ = array(
        		'S'    => 'SI',
        		'N'   => 'NO'
        );
        $this->obj->list->listae('Activo',$MATRIZ,'ESTADO','required','',$evento,'div-2-4');
        
        
        $this->obj->text->text('Nombre','texto','NOMBRE','required','','div-2-10') ;
        $this->obj->text->text('Codigo Referencia','texto','CODIGO','required','','div-2-10') ;
        
        
        $evento = '';
        $MATRIZ = array(
        		'S'    => 'SI',
        		'N'   => 'NO'
        );
        $this->obj->list->listae('Para PAC?',$MATRIZ,'VALIDAPAC','required','',$evento,'div-2-10');
           
        
        
        $this->obj->text->texto_oculto("action",$datos); 
                
        
                    
         $this->set->body_tab('','/')	;
    
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
   
    $ToolArray = array( 
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") 
                );
     
   $this->obj->boton->ToolMenu($ToolArray); 
   
 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  
  
  $gestion   = 	new componente;
  
  $gestion->Formulario( );
  
 ?>
 

  